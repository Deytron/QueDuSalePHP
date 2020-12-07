<?php

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register() {
        $user = new User();


        $form = $this->createForm(RegisterType::class);

        return $this->render('security/register.html.twig', ['formRegister' => $form->createView()]);
    }
}
