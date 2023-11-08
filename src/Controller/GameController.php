<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/new', name: 'app_game_new')]
    public function new(EntityManagerInterface $entityManager,  Request $request): Response
    {
        $form = $this->createForm(GameType::class, null,
                    [
                        'method' => 'GET',
                    ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Game saved!'
            );

            return $this->redirectToRoute('show_game', ['id' => $game->getId()]);
        }

        return $this->render('game/new.html.twig', [
            'form' => $form,
        ]);
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
    public function edit(EntityManagerInterface $entityManager, Request $request, Game $game): Response
    {
        $form = $this->createForm(
            GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Game changed!'
            );

            return $this->redirectToRoute('show_game', ['id' => $game->getId()]);
        }


        return $this->render('game/edit.html.twig', [
            'form' => $form,
            'game' => $game,
        ]);
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
