<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Repository;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubService
{
    private const QUERY = <<<'GRAPHQL'
{
  user(login: "loicsapone") {
    pinnedItems(first: 6, types: REPOSITORY) {
      nodes {
        ... on Repository {
          url
          nameWithOwner
          description 
          createdAt
          isFork
        }
      }
    }
  }
}
GRAPHQL;

    public function __construct(
        private HttpClientInterface $githubClient,
        private LoggerInterface $logger,
    ) {
    }

    public function getRepositories(): array
    {
        $repositories = [];

        try {
            $pinnedItems = $this->githubRepositoriesCache->get('pinned_items', function (ItemInterface $item) {
                try {
                    $response = $this->githubClient->request('POST', '/graphql', ['json' => ['query' => self::QUERY]]);
                    $content = $response->toArray();
                } catch (ExceptionInterface $exception) {
                    $this->logger->error(sprintf('Unable to get Github pinned repositories: %s.', $exception->getMessage()));

                    return [];
                }

                $item->expiresAfter(604800);

                return $content['data']['user']['pinnedItems']['nodes'];
            });
        } catch (InvalidArgumentException $exception) {
            $this->logger->error(sprintf('Unable to get Github pinned repositories: %s.', $exception->getMessage()));

            return [];
        }

        return $repositories;
    }
}
