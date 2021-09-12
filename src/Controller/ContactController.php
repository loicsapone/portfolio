<?php

declare(strict_types=1);

namespace App\Controller;

use App\Event\ContactEvent;
use App\Form\Type\ContactType;
use App\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_action', methods: ['POST'])]
    public function __invoke(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        dd($contact);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventDispatcher->dispatch(new ContactEvent($contact, $request));

            return new Response(null, 204);
        }

        return new Response(null, 422);
    }
}
