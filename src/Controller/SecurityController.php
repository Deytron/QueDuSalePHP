<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @Route("/secretAdminRegister", name="secretAdminRegister")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $admin = new Admin();

        $getRoute = $request->attributes->get('_route');

        if($getRoute == 'secretAdminRegister') {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($admin, $admin->getPassword());

            $admin->setPassword($hash);

            $manager->persist($admin);
            $manager->flush();

            return $this->redirectToRoute('secretAdminLogin');
        }
        return $this->render('security/register.html.twig', ['formRegister' => $form->createView()]);

        } else {
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('security/register.html.twig', ['formRegister' => $form->createView()]);
        }
    }

    /**
     * @Route("/login", name="login")
     * @Route("/secretAdminLogin", name="secretAdminLogin")
     */
    public function login(AuthenticationUtils $authenticationUtils) {

        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {
    }
}
