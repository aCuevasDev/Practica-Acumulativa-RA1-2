<?php

class Response
{
    public static function send(int $statusCode, mixed $body): never
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException('HTTP status code must be between 100 and 599.');
        }

        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $body,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}