<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Query\ContactHandler;
use App\Query\ContactQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private ContactHandler $handler,
    ) {}

    #[Route('/contact', name: 'contact_action', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->handler->handle(new ContactQuery(
                $form->get('name')->getData(),
                $form->get('email')->getData(),
                $form->get('message')->getData(),
            ));

            if ($result) {
                $this->addFlash('success', 'Votre demande de contact a bien été envoyée !');
                return $this->redirectToRoute('home_view');
            }
        }

        $this->addFlash('error', 'Désolé, votre message n\'a pas pu être envoyé.');
        return $this->redirectToRoute('home_view');
    }
}