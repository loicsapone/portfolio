<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AkismetService
{
    public function __construct(
        private HttpClientInterface $akismetClient,
        private LoggerInterface $logger,
    ) {
    }

    public function isSpam(array $context): bool
    {
        try {
            $response = $this->akismetClient->request('POST', '/1.1/comment-check', ['body' => $context]);

            $headers = $response->getHeaders();
            if ('discard' === ($headers['x-akismet-pro-tip'][0] ?? '')) {
                return true;
            }

            if (isset($headers['x-akismet-debug-help'][0])) {
                $this->logger->error('Unable to check for spam.');

                return true;
            }
        } catch (ExceptionInterface $exception) {
            $this->logger->error(sprintf('Unable to check for spam: %e', $exception->getMessage()));

            return false;
        }

        return false;
    }
}
