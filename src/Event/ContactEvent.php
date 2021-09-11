<?php

declare(strict_types=1);

namespace App\Event;

use App\Model\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class ContactEvent extends Event
{
    public function __construct(
        private Contact $contact,
        private Request $request,
    ) {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
