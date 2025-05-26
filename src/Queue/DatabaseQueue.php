<?php
namespace App\Queue;

use App\Contracts\QueueableJob;
use PDO;

class DatabaseQueue extends AbstractQueue
{
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo, string $table = 'queue_jobs')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function push(QueueableJob $job): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (payload, created_at) VALUES (:payload, NOW())");
        return $stmt->execute([
            ':payload' => serialize($job)
        ]);
    }

    public function pop(): ?QueueableJob
    {
        $this->pdo->beginTransaction();
        // Fetch the oldest job (FIFO)
        $stmt = $this->pdo->prepare("SELECT id, payload FROM {$this->table} ORDER BY id ASC LIMIT 1 FOR UPDATE");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $this->pdo->commit();
            return null;
        }

        // Delete the job
        $delStmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $delStmt->execute([':id' => $row['id']]);
        $this->pdo->commit();

        $job = unserialize($row['payload']);
        return ($job instanceof QueueableJob) ? $job : null;
    }
}