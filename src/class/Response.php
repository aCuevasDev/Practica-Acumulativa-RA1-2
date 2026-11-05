<?php

class Response
{
    private int $statusCode = 200;
    private mixed $body = '';
    /** @var array<string, string> */
    private array $headers = [];

    public static function make(): self
    {
        return new self();
    }

    public function status(int $statusCode): self
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException('HTTP status code must be between 100 and 599.');
        }

        $this->statusCode = $statusCode;

        return $this;
    }

    public function body(mixed $body): self
    {
        $this->body = $this->body . $body;

        return $this;
    }

    public function header(string $name, string $value): self
    {
        if (strcasecmp($name, 'Content-Type') === 0) {
            throw new InvalidArgumentException(
                'Response is JSON-only; the Content-Type cannot be overridden.'
            );
        }

        $this->headers[$name] = $value;

        return $this;
    }

    public function send(): never
    {
        http_response_code($this->statusCode);

        header('Content-Type: application/json; charset=utf-8');

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo json_encode(
            $this->body,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}
