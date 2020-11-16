<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contrat;
use App\Entity\Offres;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Offres::class);

        $offres = $repo->findAll();

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'offres' => $offres
        ]);
    }
}
