<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function ajouterUser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User(); 

        // Creation du formulaire d'un utilisateur
        $formUser = $this->createForm(UserType::class, $user);

        // Recuperation de la requete http
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid() )
        {
            // On lui donne le role d'utilisateur simple
            $user->setRoles(['ROLE_USER']);

            // On encode son mdp
            $mdpEncode = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($mdpEncode);

            // Enregistrer l'utilisateur en bd
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');

        }
        return $this->render('security/inscription.html.twig', [
            'form' => $formUser->createView()
        ]);
    }   
}
