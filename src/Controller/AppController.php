<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

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

        /**
     * @Route("/addOffre", name="addOffre")
     * @Route("/editOffre/{id}", name="editOffre")
     */
    public function addOffre(Offres $offre = null, HttpFoundationRequest $request, EntityManagerInterface $manager) {
        if (!$offre) {
            $offre = new Offres();
        }

            $form = $this->createFormBuilder($offre)
                         ->add('Title')
                         ->add('Description')
                         ->add('Adresse')
                         ->add('code_postal')
                         ->add('Ville')
                         ->add('fin_mission')
                         ->add('contrat')
                         ->getForm();
        
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                if(!$offre->getId()) {
                    $offre->setDateCreation(new \DateTime());
                    $offre->setUpdateDate(new \DateTime());
                }

                $manager->persist($offre);
                $manager->flush();

                return $this->redirectToRoute('offre', ['id' => $offre->getId()]);
            }
 
        return $this->render('app/addOffre.html.twig', [
            'formOffre' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="offre")
     */
    public function show($id){
    {
        $repo = $this->getDoctrine()->getRepository(Offres::class);

        $offre = $repo->find($id);

        return $this->render('app/offre.html.twig', [
            'offre' => $offre
        ]);
    }
}
}
