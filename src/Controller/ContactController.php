<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Query\ContactHandler;
use App\Query\ContactQuery;
use App\Service\AkismetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_action', methods: ['POST'])]
    public function __invoke(Request $request, ContactHandler $handler, AkismetService $akismetService): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactQuery = new ContactQuery(
                $form->get('name')->getData(),
                $form->get('email')->getData(),
                $form->get('message')->getData(),
            );

            $context = [
                'user_ip' => $request->getClientIp(),
                'user_agent' => $request->headers->get('user-agent'),
                'referrer' => $request->headers->get('referer'),
                'permalink' => $request->getUri(),
                'comment_author' => $contactQuery->getName(),
                'comment_author_email' => $contactQuery->getEmail(),
                'comment_content' => $contactQuery->getMessage(),
            ];

            if ($akismetService->getSpamScore($context) < 2 && $handler->handle($contactQuery)) {
                $this->addFlash('success', 'Votre demande de contact a bien été envoyée !');
                return $this->redirectToRoute('home_view');
            }
        }

        $this->addFlash('error', 'Désolé, votre message n\'a pas pu être envoyé.');
        return $this->redirectToRoute('home_view');
    }
}