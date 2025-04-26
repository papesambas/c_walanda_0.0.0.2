<?php

namespace App\DataFixtures;

use App\Entity\Ninas;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class NinasFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $usedDesignations = []; // Stocke les désignations déjà générées

        for ($i = 1; $i <= 500; $i++) {
            $designation = null;

            // Générer une désignation unique respectant le format requis
            do {
                $designation = $this->generateValidDesignation($faker);
            } while (in_array($designation, $usedDesignations));

            $usedDesignations[] = $designation; // Ajouter la désignation générée au tableau

            $nina = new Ninas();
            $nina->setNumero($designation);

            $manager->persist($nina);
            $this->addReference('nina_' . $i, $nina);
        }

        $manager->flush();
    }

    /**
     * Génère une désignation valide qui respecte le format requis
     */
    private function generateValidDesignation(\Faker\Generator $faker): string
    {
        // Générer une partie alphanumérique avec au moins 9 chiffres et au plus 4 lettres
        $designation = '';
        $numCount = 0;
        $letterCount = 0;

        for ($i = 0; $i < 13; $i++) {
            if ($numCount < 9 && ($letterCount >= 4 || rand(0, 1))) {
                // Ajouter un chiffre
                $designation .= $faker->randomDigit;
                $numCount++;
            } else {
                // Ajouter une lettre majuscule
                $designation .= $faker->randomLetter;
                $letterCount++;
            }
        }

        // Ajouter un espace en 14ᵉ position
        $designation .= ' ';

        // Ajouter une lettre majuscule en 15ᵉ position
        $designation .= strtoupper($faker->randomLetter);

        return $designation;
    }

    public function getDependencies(): array
    {
        return [
            Telephones2Fixtures::class
        ]; // Retirer la dépendance inutile
    }
}