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

        return $this->render('pro_stages/index.html.twig');
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
     * @Route("/stage/{id}", name="prostages_stage")
     */
    
    public function afficherStage($id): Response
    {

        return $this->render('pro_stages/afficherStage.html.twig', [
            'idStage' => $id ,
        ]);
    }

}
