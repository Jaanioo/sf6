<?php

namespace App\Controller;

use App\Service\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(private CodeGenerator $codeGenerator){

    }

    #[Route('/', name: 'index.page')]
    public function home(): Response
    {
        return $this->render('index/home.html.twig');
    }

    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }

    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = 'guest'): Response
    {
        $favouritesGames = [
            'CS',
            'LOL',
            'CSGO',
            'PUBG',
        ];
        return $this->render('index/hello.html.twig', [
            'firstName' => $firstName,
            'favouritesGames' => $favouritesGames,
        ]);
    }

    #[Route('/top', name: 'index.top')]
    public function top(): JsonResponse
    {

        return new JsonResponse($this->codeGenerator->pickRandomGames());
    }

    #[Route('/code', name: 'index.code')]
    public function code(Filesystem $filesystem, CodeGenerator $codeGenerator): Response
    {
        $code = $codeGenerator->generate();

        return $this->render('index/code.html.twig', ['code' => $code]);
    }
}