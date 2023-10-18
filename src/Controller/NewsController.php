<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager->getRepository(News::class)->findAll();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/news/{id}', name: 'news_show_one')]
    public function showOne(News $news): Response
    {
        return $this->render('news/show_one.html.twig', [
            'news' => $news,
            'comments' => $news->getNewsComments(),
        ]);
    }

    #[Route('/new/news', name: 'news_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $new = new News();

        $new->setTitle('News Title')
            ->setText('News Text')
            ->setCreatedAt(new \DateTimeImmutable('2007-08-21'));

        $entityManager->getRepository(News::class)->save($new, true);

        return new Response('Saved new news: ');
    }

    #[Route('/news/edit/{id}', name: 'news_edit_one')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $new = $entityManager->getRepository(News::class)->find($id);

        if (!$new) {
            throw $this->createNotFoundException('New not found' . $id);
        }

        $new->setTitle('NOWY TYTUL');

        $entityManager->flush();

        return $this->redirectToRoute('news_show_one', ['id' => $new->getId()]);
    }

    #[Route('/news/delete/{id}', name: 'news_delete_one')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $new = $entityManager->getRepository(News::class)->find($id);

        if (!$new) {
            throw $this->createNotFoundException('New not found'. $id);
        }

        $entityManager->getRepository(News::class)->remove($new, true);

        return $this->redirectToRoute('news_index');
    }
}
