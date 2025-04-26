<?php

namespace App\DataFixtures;

use App\Entity\Telephones1;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class Telephones1Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $usedNumbers = []; // Tableau pour stocker les numéros déjà utilisés

        for ($i = 1; $i <= 300; $i++) {
            $numero = null;

            // Générer un numéro unique
            do {
                $numero = '+223' . $faker->numerify('########');
            } while (in_array($numero, $usedNumbers)); // Vérifie si déjà utilisé

            $usedNumbers[] = $numero; // Ajouter au tableau des numéros utilisés

                $telephone = new Telephones1();
                $telephone->setNumero($numero);
                $manager->persist($telephone);
                $this->addReference('telephone_' . $i, $telephone);
        }

        $manager->flush();
}

    public function getDependencies(): array
    {
        return [
            ProfessionsFixtures::class
        ];
    }

}
