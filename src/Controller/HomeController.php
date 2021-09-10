<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Service\GithubService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_view', methods: ['GET'])]
    public function __invoke(GithubService $githubService): Response
    {
        $response = $this->render('homepage.html.twig', [
            'repositories' => $githubService->getRepositories(),
            'form'         => $this->createForm(ContactType::class)->createView(),
        ]);

        $response->setPublic();
        $response->setSharedMaxAge(86400);

        return $response;
    }
}
