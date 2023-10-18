<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $game->setName('LOL')
            ->setDescription('League of Legends')
            ->setScore(10)
            ->setReleaseDate(new \DateTime('2007-08-21'));

        $entityManager->getRepository(Game::class)->save($game, true);

        return new Response('Saved new game with name: ' . $game->getName());
    }

    #[Route('/game/{id}', name: 'show_game')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/games', name: 'game_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAll();

        return $this->render('game/list.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/game/edit/{id}', name: 'game_edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Game not found' . $id);
        }

        $game->setScore(5);

        $entityManager->flush();

        return $this->redirectToRoute('show_game', ['id' => $game->getId()]);
    }

    #[Route('/game/delete/{id}', name: 'game_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Game not found'. $id);
        }

        $entityManager->remove($game);
        $entityManager->flush();

        return $this->redirectToRoute('game_list');
    }

    #[Route('/games/top', name: 'game_list_top')]
    public function topList(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAllTopScoredGames();

        return $this->render('game/top_list.html.twig', [
            'games' => $games,
        ]);
    }
}
