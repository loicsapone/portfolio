<?php

declare(strict_types=1);

namespace App\Query;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class ContactHandler
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    public function handle(ContactQuery $query): bool
    {
        $email = (new TemplatedEmail())
            ->from($query->getEmail())
            ->replyTo($query->getEmail())
            ->to('loic@sapone.fr')
            ->subject('Portfolio | Nouvelle demande de contact')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'name'    => $query->getName(),
                'message' => $query->getMessage(),
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }
}
