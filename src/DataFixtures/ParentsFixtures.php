<?php

namespace App\DataFixtures;

use App\Entity\Meres;
use App\Entity\Peres;
use App\Entity\Parents;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class ParentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 80; $i++) {
            $pere = $this->getReference('pere_' . $faker->numberBetween(1, 80), Peres::class);
            $mere = $this->getReference('mere_' . $faker->numberBetween(1, 100), Meres::class);
            $parent = new Parents();
            $parent->setPere($pere);
            $parent->setMere($mere);

            $manager->persist($parent);
            $this->addReference('parent_' . $i, $parent);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MeresFixtures::class,
        ];
    }
}
