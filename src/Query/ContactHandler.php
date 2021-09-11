<?php

declare(strict_types=1);

namespace App\Query;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactHandler
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    public function handle(ContactQuery $query): bool
    {
        $email = (new Email())
            ->from($query->getEmail())
            ->replyTo($query->getEmail())
            ->to('loic@sapone.fr')
            ->subject('Portfolio | Nouvelle demande de contact')
            ->html(sprintf(
                '<strong>%s</strong> (%s) vous a contacté via le formulaire de contact :<br /><br />%s',
                $query->getName(),
                $query->getEmail(),
                $query->getMessage()
            ));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }
}
