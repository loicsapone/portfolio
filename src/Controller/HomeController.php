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
        $repositories = [
            [
                'url' => 'https://github.com/loicsapone/portfolio',
                'name' => 'loicsapone/portfolio',
                'description' => 'My own website',
                'createdAt' => new \DateTime('2021-05-10T16:07:03Z'),
                'forked' => false,
            ],
            [
                'url' => 'https://github.com/IQ2i/data-importer',
                'name' => 'IQ2i/data-importer',
                'description' => 'A PHP library to easily manage and import large data file',
                'createdAt' => new \DateTime('2021-05-10T16:07:03Z'),
                'forked' => false,
            ],
            [
                'url' => 'https://github.com/IQ2i/aergie',
                'name' => 'IQ2i/aergie',
                'description' => 'An easy alternative to makefile',
                'createdAt' => new \DateTime('2020-09-30T06:50:47Z'),
                'forked' => false,
            ],
            [
                'url' => 'https://github.com/IQ2i/prestashop-webservice-bundle',
                'name' => 'IQ2i/prestashop-webservice-bundle',
                'description' => 'Symfony bundle to wrap Prestashop official webservice client',
                'createdAt' => new \DateTime('2015-04-10T19:32:37Z'),
                'forked' => false,
            ],
            [
                'url' => 'https://github.com/loicsapone/symfony-docs',
                'name' => 'loicsapone/symfony-docs',
                'description' => 'The Symfony documentation',
                'createdAt' => new \DateTime('2010-02-17T08:43:51Z'),
                'forked' => true,
            ],
            [
                'url' => 'https://github.com/loicsapone/PrestaShop',
                'name' => 'loicsapone/PrestaShop',
                'description' => 'PrestaShop offers a fully scalable open source ecommerce solution.',
                'createdAt' => new \DateTime('2012-11-19T16:41:31Z'),
                'forked' => true,
            ],
        ];


        return $this->render('home/view.html.twig', [
            'repositories' => $repositories
        ]);
    }
}