<?php
namespace App\Queue;

use App\Contracts\QueueableJob;

abstract class AbstractQueue
{
    /**
     * Push a job onto the queue.
     *
     * @param QueueableJob $job
     * @return bool
     */
    abstract public function push(QueueableJob $job): bool;

    /**
     * Pop the next job off the queue.
     *
     * @return QueueableJob|null
     */
    abstract public function pop(): ?QueueableJob;

    /**
     * Process the next job (if any).
     */
    public function processNext(): void
    {
        $job = $this->pop();
        if ($job) {
            $job->handle();
        }
    }
}