<?php

namespace App\Model;

class Repository
{
    public function __construct(
        private string $url,
        private string $name,
        private string $description,
        private \DateTimeInterface $createdAt,
        private bool $fork,
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function isFork(): bool
    {
        return $this->fork;
    }
}
