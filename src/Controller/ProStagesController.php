<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;


class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */

    public function index(): Response
    {
        $stageRepo = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $stageRepo->findAll();
        
        return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages
        ]);
    }

    /**
     * @Route("/filtrer", name="prostages_filtrer")
     */
    
    public function filtrer(): Response
    {

        $entrepriseRepo = $this->getDoctrine()->getRepository(Entreprise::class);
        $entreprises = $entrepriseRepo->findAll();

        $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
        $formations = $formationRepo->findAll();
        return $this->render('pro_stages/filtrer.html.twig', [
            'entreprises' => $entreprises,
            'formations' => $formations 

        ]);    }


    /**
     * @Route("/stage{id}", name="prostages_stage")
     */
    
    public function afficherStage($id): Response
    {
        $stageRepo = $this->getDoctrine()->getRepository(Stage::class);
        $stage = $stageRepo->find($id);

        return $this->render('pro_stages/afficherStage.html.twig', [
            'stage' => $stage
        ]);
    }
        
    /**
     * @Route("/entreprise{idEntreprise}", name="prostages_stagesParEntreprise")
     */
    
    public function stagesParEntreprise($idEntreprise)
    {
        $entrepriseRepo = $this->getDoctrine()->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepo->find($idEntreprise);

        $stages = $entreprise->getStages();
        $filtrerPar = $entreprise->getNom();
        
            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $filtrerPar
        ]);
    }

       /**
     * @Route("/formation{idFormation}", name="prostages_stagesParFormation")
     */
    
    public function stagesParFormation($idFormation)
    {
        
        $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
        $formation = $formationRepo->find($idFormation);

        $stages = $formation->getStages();
        $filtrerPar = $formation->getFormation();

            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $filtrerPar
        ]);
    }
        
}
