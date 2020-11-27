<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */

    public function index(): Response
    {
        /*return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
        ]); */

        return new Response ('<h1> Bienvenue sur la page d\'accueil de Prostages </h1 >');
    }

    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    
    public function afficherEntreprises(): Response
    {

        return new Response ('<h1> Cette page affichera la liste des entreprises proposant un stage </h1 >');
    }

    /**
     * @Route("/formations", name="prostages_formations")
     */
    
    public function afficherFormations(): Response
    {

        return new Response ('<h1> Cette page affichera la liste des formations de l\'IUT </h1 >');
    }

    /**
     * @Route("/stages/{id}", name="prostages_stages")
     */
    
    public function afficherStage($id): Response
    {

        return new Response("Cette page affichera le descriptif du stage ayant pour identifiant $id");
    }

}
