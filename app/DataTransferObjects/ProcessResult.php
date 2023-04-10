<?php

namespace App\DataTransferObjects;

class ProcessResult
{
    private int $status = 0;
    private string $message = '';

    public static function create(): static
    {
        return new self();
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }
}
