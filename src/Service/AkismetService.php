<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AkismetService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $akismetApiKey,
        private string $appDefaultUri,
    ) {
    }

    public function getSpamScore(array $context): int
    {
        $response = $this->client->request('POST', sprintf('https://%s.rest.akismet.com/1.1/comment-check', $this->akismetApiKey), [
            'body' => array_merge($context, [
                'blog'             => $this->appDefaultUri,
                'comment_type'     => 'contact-form',
                'comment_date_gmt' => (new \DateTime())->format('c'),
                'blog_lang'        => 'fr',
                'blog_charset'     => 'UTF-8',
            ]),
        ]);

        $headers = $response->getHeaders();
        if ('discard' === ($headers['x-akismet-pro-tip'][0] ?? '')) {
            return 2;
        }

        $content = $response->getContent();
        if (isset($headers['x-akismet-debug-help'][0])) {
            throw new \RuntimeException(sprintf('Unable to check for spam: %s (%s).', $content, $headers['x-akismet-debug-help'][0]));
        }

        return 'true' === $content ? 1 : 0;
    }
}
