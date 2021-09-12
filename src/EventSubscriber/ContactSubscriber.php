<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\ContactEvent;
use App\Service\AkismetService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private AkismetService $akismetService,
        private MailerInterface $mailer,
        private LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactEvent::class => 'onContactReceived',
        ];
    }

    public function onContactReceived(ContactEvent $event): void
    {
        $request = $event->getRequest();
        $contact = $event->getContact();

        $context = [
            'blog'                 => $request->getSchemeAndHttpHost(),
            'blog_lang'            => 'fr',
            'blog_charset'         => 'UTF-8',
            'user_ip'              => $request->getClientIp(),
            'user_agent'           => $request->headers->get('user-agent'),
            'referrer'             => $request->headers->get('referer'),
            'permalink'            => $request->getUri(),
            'comment_author'       => $contact->getName(),
            'comment_author_email' => $contact->getEmail(),
            'comment_content'      => $contact->getMessage(),
            'comment_type'         => 'contact-form',
            'comment_date_gmt'     => (new \DateTime())->format('c'),
        ];

        if ($this->akismetService->isSpam($context)) {
            $this->logger->error('Spam detected, contact blocked');

            return;
        }

        $email = (new Email())
            ->from($contact->getEmail())
            ->replyTo($contact->getEmail())
            ->to('loic@sapone.fr')
            ->subject('Portfolio | Nouvelle demande de contact')
            ->html(sprintf(
                '<strong>%s</strong> (%s) vous a contacté via le formulaire de contact :<br /><br />%s',
                $contact->getName(),
                $contact->getEmail(),
                $contact->getMessage()
            ));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(sprintf('Error during contact sending: %s', $e->getMessage()));

            return;
        }

        $this->logger->info('Contact email sent.');
    }
}
