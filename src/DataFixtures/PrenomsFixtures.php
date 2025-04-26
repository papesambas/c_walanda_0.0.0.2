<?php

namespace App\DataFixtures;

use App\Entity\Prenoms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PrenomsFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counteur = 0; // Compteur pour les références

    public function load(ObjectManager $manager): void
    {
        $prenomsDeFamilleMali =  [
            'Aïcha', 'Aminata', 'Fatoumata', 'Mariam', 'Kadiatou', 'Awa', 'Hawa', 'Aminou', 'Oumou', 'Adama',
            'Bintou', 'Fanta', 'Nafissatou', 'Ramatoulaye', 'Sira', 'Maimouna', 'Djeneba', 'Kadidia', 'Mariame', 'Sokhna',
            'Abdoulaye', 'Mamadou', 'Ibrahima', 'Amadou', 'Boubacar', 'Cheick', 'Modou', 'Aliou', 'Souleymane', 'Ousmane',
            'Moussa', 'Bakary', 'Sékou', 'Alpha', 'Mohamed', 'Samba', 'Yaya', 'Mamady', 'Seydou', 'Habib',
            'Karim', 'Ismaël', 'Youssouf', 'Daouda', 'Mahamadou', 'Salif', 'Brahima', 'Sidi', 'Tidiane',
            'Koffi', 'Yao', 'Kouamé', 'Aka', 'Kouassi', 'Kouadio', 'N’Guessan', 'Gnahoré', 'Maguiraga', 'Kamissoko',
            'Issoufou', 'Tandja', 'Bazoum', 'Abdou', 'Sani', 'Yacouba', 'Hassane', 'Ali', 'Ibrahim', 'Souley',
            'Harouna', 'Mamane', 'Saidou', 'Idrissa', 'Mahamane', 'Oumarou', 'Yahaya', 'Habibou', 'Adamou',
            'Garba', 'Kassoum', 'Boubou', 'Salifou', 'Soumana', 'Djibo', 'Abdourahamane', 'Issa', 'Koné', 'Diabaté',
            'Sidiki', 'Babacar', 'Elhadji', 'Fousseyni', 'Kader', 'Lamine', 'Ismaïla', 'Cheikh', 'Oumar', 'Mamadoulaye',
            'Aissatou', 'Khadija', 'Rokia', 'Seynabou'
        ];

        foreach ($prenomsDeFamilleMali as $prenom) {
            $prenomEntity = new Prenoms();
            $prenomEntity->setDesignation($prenom);
            $manager->persist($prenomEntity);

            // Utilisez le compteur pour créer une référence unique
            $this->setReference('prenom_' . $this->counteur, $prenomEntity);
            $this->counteur++; // Incrémentez le compteur
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NomsFixtures::class
        ];
    }
}