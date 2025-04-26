<?php

namespace App\DataFixtures;

use App\Entity\Telephones2;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class Telephones2Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $usedNumbers = []; // Tableau pour stocker les numéros déjà utilisés

        for ($i = 301; $i <=600 ; $i++) {
            $numero = null;

            // Générer un numéro unique
            do {
                $numero = '+223' . $faker->numerify('########');
            } while (in_array($numero, $usedNumbers)); // Vérifie si déjà utilisé

            $usedNumbers[] = $numero; // Ajouter au tableau des numéros utilisés

                $telephone = new Telephones2();
                $telephone->setNumero($numero);
                $manager->persist($telephone);
                $this->addReference('telephone2_' . $i, $telephone);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            Telephones1Fixtures::class
        ];
    }

}
