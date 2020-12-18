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
     * @Route("/filtrer", name="prostages_filtrer")
     */
    
    public function filtrer(): Response
    {

        return $this->render('pro_stages/filtrer.html.twig');    }



    /**
     * @Route("/stage{id}", name="prostages_stage")
     */
    
    public function afficherStage($id): Response
    {

        return $this->render('pro_stages/afficherStage.html.twig', [
            'idStage' => $id ,
        ]);
    }

}
