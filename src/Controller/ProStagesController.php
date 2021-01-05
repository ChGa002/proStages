<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;


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
        
    /**
     * @Route("/entreprise/{idEntreprise}", name="prostages_stagesParEntreprise")
     */
    
    public function stagesParEntreprise($idEntreprise)
    {
        $stageRepo = $this->getDoctrine()->getRepository(Stage::class);
        $entrepriseRepo = $this->getDoctrine()->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepo->find($idEntreprise);
        $stages = $stageRepo->findByEntreprise($idEntreprise);
        
            return $this->render('pro_stages/listeStages.html.twig', [
            'stages' => $stages,
            'nomEntreprise' => $entreprise->getNom()
        ]);
    }
        
}
