<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	// Creation d'un faker francais
    	$faker = \Faker\Factory::create('fr_FR'); 


        /***************************************
        *** CREATION DES FORMATIONS ***
        ****************************************/
        $dutInfo = new Formation();
        $dutInfo->setFormation("DUT Informatique");

        $dutGim = new Formation();
        $dutGim->setFormation("DUT Génie industriel et maintenance");

        $lpNum = new Formation();
        $lpNum->setFormation("LP Métiers du Numérique");

        $lpPa = new Formation();
        $lpPa->setFormation("LP Programmation avancée");

        /* On regroupe les objets "formation" dans un tableau
        pour pouvoir s'y référer au moment de la création d'un stage particulier */
        $tableauFormations = array($dutInfo,$dutGim,$lpNum,$lpPa);

        // Mise en persistance des objets formation
        foreach ($tableauFormations as $formation) {
            $manager->persist($formation);
        }

        // Declaration d'un tableau de domaine de stage 
        $tableauDomaines = array("web","mobilité","réseau");
         /***************************************
        *** CREATION DES ENTREPRISES ***
        ****************************************/

        $nbEntreprises = 9;
        for ($i=1; $i <= $nbEntreprises; $i++) {

            // Création d'un nouveau stage
	        $entreprise = new Entreprise();
	        $entreprise->setNom($faker->company);
	        $entreprise->setActivite($faker->jobTitle);
			$entreprise->setAdresse($faker->address);

	        $manager->persist($entreprise);

	        $nbStages = $faker->numberBetween($min = 1, $max = 5);
	        /********************************************************
	        *** CREATION DES STAGES D'UNE ENTREPRISE  ***
	        *********************************************************/
	      	for ($j=1 ; $j <= $nbStages; $j++)
	      	{
	            // ************* Création d'un nouveau stage *************
	            $stage = new Stage();

	            // Définition du titre du stage
	            $stage->setTitre($faker->sentence($nbWords = 5, $variableNbWords = true));

	            // Definition de sa description
	            $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));

	            // Definition de l'adresse mail
	            $stage->setEmail($faker->companyEmail);

	            // Choix du domaine du stage
	            $domaine = $faker->numberBetween($min = 0, $max = 2);
	            $stage->setDomaine($tableauDomaines[$domaine]);

	            // Enregistrement du stage
	            $manager->persist($stage);

	            // ************** Ajout de ce stage dans l'entreprise ********

	            $entreprise->addStage($stage);
	            $manager->persist($entreprise);

	                /****** Mettre en lien le stage avec une ou plusieurs formation(s) ******/
	                // On genere un nombre aleatoire de formations concernees par le stage
	                $nbFormationsConcernees = $faker->numberBetween($min = 0, $max = 3);

	                for ($m=0 ; $m <= $nbFormationsConcernees; $m++)
	                {
	                	// On choisit le numero de la formation concernee
	                	$formationConcernee = $faker->numberBetween($min = 0, $max = 3);

	                	$tableauFormations[$formationConcernee]->addStage($stage);

	                	// On enregistre les modifications
	                	$manager->persist($tableauFormations[$formationConcernee]);
						
	                }

                $manager->flush();
            }
        }
 		
    }
}
