<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AkismetService
{
    public function __construct(
        private string $akismetApiKey,
        private HttpClientInterface $client,
        private LoggerInterface $logger,
    ) {
    }

    public function isSpam(array $context): bool
    {
        $response = $this->client->request('POST', sprintf('https://%s.rest.akismet.com/1.1/comment-check', $this->akismetApiKey), [
            'body' => array_merge($context, [
                'comment_type'     => 'contact-form',
                'comment_date_gmt' => (new \DateTime())->format('c'),
                'blog_lang'        => 'fr',
                'blog_charset'     => 'UTF-8',
            ]),
        ]);

        $headers = $response->getHeaders();
        if ('discard' === ($headers['x-akismet-pro-tip'][0] ?? '')) {
            return true;
        }

        $content = $response->getContent();
        if (isset($headers['x-akismet-debug-help'][0])) {
            $this->logger->error(sprintf('Unable to check for spam: %s (%s).', $content, $headers['x-akismet-debug-help'][0]));

            return true;
        }

        return false;
    }
}
