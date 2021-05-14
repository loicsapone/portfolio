<?php

declare(strict_types=1);

namespace App\Controller;

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
    public function __invoke(): Response
    {
        return $this->render('home/view.html.twig');
    }
}