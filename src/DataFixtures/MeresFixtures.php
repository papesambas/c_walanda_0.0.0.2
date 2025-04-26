<?php

namespace App\DataFixtures;

use App\Entity\Noms;
use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\Entity\Telephones1;
use App\Entity\Telephones2;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class MeresFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $usedPhoneNumbers = [];
        $usedPhoneNumbers1 = [];
        $usedNina = [];



        for ($i = 1; $i <= 100; $i++) {
            $profession = $this->getReference('profession_' . $faker->numberBetween(1, 150),Professions::class);
            $mere = new Meres();

            do {
                $telephone1 = $this->getReference('telephone_' . $faker->numberBetween(151, 300), Telephones1::class);
            } while (in_array($telephone1->getId(), $usedPhoneNumbers));

            do {
                $telephone2 = $this->getReference('telephone2_' . $faker->numberBetween(351, 600), Telephones2::class);
            } while (in_array($telephone2->getId(), $usedPhoneNumbers1));

            do {
                $nina = $this->getReference('nina_' . $faker->numberBetween(151, 300), Ninas::class);
            } while (in_array($nina->getId(), $usedNina));

            $usedPhoneNumbers[] = $telephone1->getId();
            $usedPhoneNumbers1[] = $telephone2->getId();
            $usedNina[] = $nina->getId();


            $nom = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
            $prenom = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
            $mere->setNom($nom);
            $mere->setPrenom($prenom);
            $mere->setProfession($profession);
            $mere->setTelephone1($telephone1);
            $mere->setTelephone2($telephone2);
            $mere->setNina($nina)
        ;

            $manager->persist($mere);
            $this->addReference('mere_' . $i, $mere);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PeresFixtures::class,
        ];
    }

}
