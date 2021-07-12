<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class GithubService
{
    public function __construct(
        private string $filename
    ) {
    }

    public function getRepositories(): array
    {
        $data = Yaml::parseFile($this->filename, Yaml::PARSE_DATETIME);

        return $data['github']['repositories'] ?? [];
    }
}
