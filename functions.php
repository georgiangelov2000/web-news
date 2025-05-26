<?php
// Helpers for JSON responses
function jsonError(string $message, int $status = 400): void
{
    http_response_code($status);
    echo json_encode(['status' => 'error', 'message' => $message]);
}

function jsonSuccess(array $data = []): void
{
    http_response_code(200);
    echo json_encode(['status' => 'success'] + $data);
}