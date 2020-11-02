<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     */
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route("/articles", name="show.articles")
     * @return void
     */

    public function articles_list(ArticleRepository $repo, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitle('Envie de démonter un cul')
            ->setDescription('lorem')
            ->setCreatedAt(new \DateTime());

        $article2 = new Article();
        $article2->setTitle('Putain je suis trop bien là')
            ->setDescription('lorem')
            ->setCreatedAt(new \DateTime());

        $entityManager->persist($article);
        $entityManager->persist($article2);

        $entityManager->flush();

        return new Response("Success flush");

        #$articles = [];
        #array_push($articles, $article, $article2);

        #dd($articles);

        #return $this->render('app/list.html.twig', [
        #'articles' => $articles
        #]);
    }
}
