<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/page/home', name: 'page.home')]
    public function home(): Response
    {
        $data = [
            'title' => 'Strona główna',
            'date' => new \DateTime(),
            'messages' => [
                ['id' => 1, 'text' => 'Pierwsza wiadomość', 'author' => 'Jan Kowalski'],
                ['id' => 2, 'text' => 'Druga wiadomość', 'author' => 'Anna Nowak'],
            ],
            'numbers' => [1, 2, 3, 4, 5],
            'weather' => ['temperature' => 20, 'condition' => 'słonecznie'],
            'isPremiumUser' => true,
            'user' => ['name' => 'Jan Kowalski', 'email' => 'jan.kowalski@example.com'],
            'pageViews' => 1234,
            'popularTags' => ['symfony', 'twig', 'php', 'mvc'],
            'rating' => 2.3
        ];

        return $this->render('page/home.html.twig', ['data' => $data]);
    }
}