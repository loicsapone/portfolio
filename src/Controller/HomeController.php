<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Service\GithubService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[
        Route('/', name: 'home_view', methods: ['GET']),
        Cache(maxage: 604800, public: true)
    ]
    public function __invoke(GithubService $githubService): Response
    {
        return $this->render('home/view.html.twig', [
            'repositories' => $githubService->getRepositories(),
            'form' => $this->createForm(ContactType::class)->createView()
        ]);
    }
}