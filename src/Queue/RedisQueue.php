<?php
namespace App\Queue;

use App\Contracts\QueueableJob;
use Redis;

class RedisQueue extends AbstractQueue
{
    protected Redis $redis;
    protected string $queueName;

    public function __construct(Redis $redis, string $queueName = 'queue:default')
    {
        $this->redis = $redis;
        $this->queueName = $queueName;
    }

    public function push(QueueableJob $job): bool
    {
        // Store as serialized payload
        $payload = serialize($job);
        return $this->redis->rpush($this->queueName, $payload) > 0;
    }

    public function pop(): ?QueueableJob
    {
        $payload = $this->redis->lpop($this->queueName);
        if ($payload === false || $payload === null) {
            return null;
        }
        $job = unserialize($payload);
        return ($job instanceof QueueableJob) ? $job : null;
    }
}