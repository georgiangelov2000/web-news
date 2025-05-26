<?php
namespace App\Contracts;

interface QueueableJob
{
    public function handle();
}