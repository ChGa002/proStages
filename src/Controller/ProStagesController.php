<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntrepriseType;
use App\Form\StageType;

use Doctrine\ORM\EntityManagerInterface;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */

    public function index(StageRepository $stageRepo): Response
    {
        $stages = $stageRepo->findAllOptimise();
        
        return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages
        ]);
    }

    /**
     * @Route("/filtrer", name="prostages_filtrer")
     */
    
    public function filtrer(EntrepriseRepository $entrepriseRepo, 
                            FormationRepository $formationRepo): Response
    {
        $entreprises = $entrepriseRepo->findAll();
        $formations = $formationRepo->findAll();

        return $this->render('pro_stages/filtrer.html.twig', [
            'entreprises' => $entreprises,
            'formations' => $formations 

        ]);    }


    /**
     * @Route("/stage{id}", name="prostages_stage")
     */
    
    public function afficherStage(Stage $stage): Response
    {

        return $this->render('pro_stages/afficherStage.html.twig', [
            'stage' => $stage
        ]);
    }
        
    /**
     * @Route("/entreprise/{nom}", name="prostages_stagesParEntreprise")
     */
    
    public function stagesParEntreprise(StageRepository $stageRepo, $nom)
    {
       
        $stages = $stageRepo->findByEntreprise($nom);
        
            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $nom
        ]);
    }

       /**
     * @Route("/formation/{formation}", name="prostages_stagesParFormation")
     */
    
    public function stagesParFormation(StageRepository $stageRepo, $formation)
    {
        $stages = $stageRepo->findByFormation($formation);

            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $formation
        ]);
    }
    
    /**
     * @Route("/admin/ajouter/entreprise", name="prostages_ajouterEntreprise")
     */

    public function ajouterEntreprise(Request $request, EntityManagerInterface $manager): Response
    {
        $entreprise = new Entreprise(); 

        // Creation du formulaire d'une entreprise
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Recuperation de la requete http
        $formEntreprise->handleRequest($request);

        if ($formEntreprise->isSubmitted() && $formEntreprise->isValid() )
        {
            // Enregistrer l'entreprise en bd
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('prostages_filtrer');

        }
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $formEntreprise->createView(),
            'action' => "creer"
        ]);
    }   

      /**
     * @Route("/admin/modifier/entreprise/{id}", name="prostages_modifierEntreprise")
     */

    public function modifierEntreprise(Request $request, Entreprise $entreprise, EntityManagerInterface $manager): Response
    {

        // Creation du formulaire d'une entreprise
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Recuperation de la requete http
        $formEntreprise->handleRequest($request);

        if ($formEntreprise->isSubmitted() && $formEntreprise->isValid()  )
        {
            // Enregistrer l'entreprise en bd
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute('prostages_filtrer');
        }
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $formEntreprise->createView(),
            'action' => "modifier"
        ]);

    }

     /**
     * @Route("/ajouter/stage", name="prostages_ajouterStage")
     */

    public function ajouterStage(Request $request, EntityManagerInterface $manager): Response
    {
        $stage = new Stage(); 

        // Creation du formulaire d'une entreprise
        $formStage = $this->createForm(StageType::class, $stage);

        // Recuperation de la requete http
        $formStage->handleRequest($request);

        if ($formStage->isSubmitted() && $formStage->isValid()  )
        {
            // Enregistrer le stage en bd
            $manager->persist($stage);
            $manager->flush();
            return $this->redirectToRoute('prostages_accueil');
        }
        return $this->render('pro_stages/ajoutStage.html.twig', [
            'form' => $formStage->createView()
        ]);

    }
}
