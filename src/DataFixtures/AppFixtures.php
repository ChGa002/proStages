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
    	$faker = Faker\Factory::create('fr_FR'); 


        /***************************************
        *** CREATION DES FORMATIONS ***
        ****************************************/
        $DUTINFO = new Formation();
        $DUTINFO->setFormation("DUT Informatique");

        $DUTGIM = new Formation();
        $DUTGIM->setFormation("DUT Génie industriel et maintenance");

        $LPNUM = new Formation();
        $LPNUM->setFormation("LP Métiers du Numérique");

        $LPPA = new Formation();
        $LPPA->setFormation("LP Programmation avancée");

        /* On regroupe les objets "formation" dans un tableau
        pour pouvoir s'y référer au moment de la création d'un stage particulier */
        $tableauFormations = array($DUTINFO,$DUTGIM,$LPNUM,$LPPA);

        // Mise en persistance des objets formation
        foreach ($tableauFormations as $formation) {
            $manager->persist($formation);
        }

         /***************************************
        *** CREATION DES ENTREPRISES ***
        ****************************************/

         $nbEntreprises = 15;
        for ($i=1; $i <= $nbEntreprises; $i++) {
            // Création d'un nouveau stage
        $Entreprise = new Entreprise();
        $Entreprise->setNom($faker->company) 
        $manager->flush();


        /********************************************************
        *** CREATION DES MODULES ET DES RESSOURCES ASSOCIEES  ***
        *********************************************************/
        foreach ($modulesDutInfo as $codeModule => $titreModule) {
            // ************* Création d'un nouveau module *************
            $module = new Module();
            // Génération d'un numéro de semestre compris entre 1 et 4
            $numSemestre = $faker->numberBetween($min = 1, $max = 4);
            // Définition du code du semestre
            $module->setCode($faker->regexify('M'.$numSemestre.'[1-2]0[1-6]'));
            $module->setCode($codeModule);
            // Définition du titre du semestre
            $module->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
            $module->setTitre($titreModule);
            // Définition du numéro du semestre
            $module->setSemestre($numSemestre);
            $module->setSemestre($codeModule[1]);
            // Enregistrement du module créé
            $manager->persist($module);

            // **** Création de plusieurs ressources associées au module
            $nbRessourcesAGenerer = $faker->numberBetween($min = 0, $max = 7);
            for ($numRessource=0; $numRessource < $nbRessourcesAGenerer; $numRessource++) {
                $ressource = new Ressource();
                $ressource -> setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
                $ressource -> setDescriptif($faker->realText($maxNbChars = 200, $indexSize = 2));
                $ressource -> setDateAjout($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = 'Europe/Paris'));
                $ressource -> setUrlRessource($faker->url);
                $ressource -> setUrlVignette($faker->imageUrl(400, 400, 'technics'));
                // Création relation Ressource --> Module
                $ressource -> addModule($module);

                /****** Définir et mettre à jour le type de ressource ******/
                // Sélectionner un type de ressource au hasard parmi les 8 types enregistrés dans $tableauFormation
                $numTypeRessource = $faker->numberBetween($min = 0, $max = 7);
                // Création relation Ressource --> TypeRessource
                $ressource -> setTypeRessource($tableauFormation[$numTypeRessource]);
                // Création relation TypeRessource --> Ressource
                $tableauFormation[$numTypeRessource] -> addRessource($ressource);

                // Persister les objets modifiés
                $manager->persist($ressource);
                $manager->persist($tableauFormation[$numTypeRessource]);
            }
        }

        $Formation = new Formation();
        $Formation->setFormation("DUT Informatique");
        $manager->persist($Formation);


        $Entreprise = new Entreprise();
        $Entreprise->setFormation($faker->company) 
        $manager->flush();
    }
}
