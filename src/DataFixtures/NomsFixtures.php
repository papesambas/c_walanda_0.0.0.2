<?php

namespace App\DataFixtures;

use App\Entity\Noms;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NomsFixtures extends Fixture
{
    private int $counteur = 0; // Compteur pour les références

    public function load(ObjectManager $manager): void
    {
        $nomsDeFamilleMali = [
            'Sidibé', 'Diakité', 'Diallo', 'Sangaré', 'Traoré', 'Diarra', 'Coulibaly', 'Bagayoko',
            'Fofana', 'Keita', 'Touré', 'Sissoko','Sissako' ,'Cissé', 'Sow', 'N’Diaye', 'Sanogo', 'Bamba',
            'Maïga', 'Sako', 'Kouyaté', 'Konaté', 'Dembélé', 'Doumbia', 'Kaba','Guindo','Dolo','Garango', 'Ba', 'Yattara',
            'Soro', 'Samaké', "M'Baye", 'Tangara', 'Diop', 'Koné', 'Kanté','Kelepili','Karembe', 'Ndiaye', 'Fall',
            'Gueye', 'Mbaye', 'Sy', 'Kane', 'Diouf', 'Thiam', 'Sène', 'Niang', 'Faye', 'Sarr',
            'Mbacké', 'Seck', 'Dia', 'Samb', 'Diagne', 'Lo', 'Gning', 'Ndour', 'Wade', 'Sall',
            'Mane', 'Diakhaté', 'Sakho', 'Dione', 'Ka', 'Sagna', 'Ndao', 'Diatta', 'Gaye', 'Bah',
            'Camara', 'Barry', 'Sylla', 'Condé', 'Dramé', 'Sacko', 'Baldé', 'Kourouma', 'Doumbouya',
            'Sano', 'Bangoura', 'Diao', 'Soumah', 'Dabo', 'Cissoko', 'Ouédraogo', 'Kaboré',
            'Sawadogo', 'Zongo', 'Kinda', 'Nikiéma', 'Compraoré', 'Zerbo', 'Ouattara', 'Bado',
            'Kafando', 'Sana', 'Boukary', 'Yaméogo', 'Bikienga', 'Kiemtoré', 'Sankara', 'Issoufou',
            'Mahamadou', 'Tandja', 'Ousmane', 'Bazoum', 'Abdou', 'Moussa', 'Sani', 'Yacouba',
            'Hassane', 'Amadou', 'Ali', 'Ibrahim', 'Souley', 'Harouna', 'Mamane', 'Daouda',
            'Abdoulaye', 'Saidou', 'Idrissa', 'Mahamane', 'Oumarou', 'Yahaya', 'Habibou', 'Adamou',
            'Garba', 'Kassoum', 'Boubou', 'Salifou', 'Soumana', 'Djibo', 'Abdourahamane', 'Issa',
            'Kouamé', 'Yao', 'Kouassi', 'Aka', 'Diabaté', 'Koffi', 'Kouadio', 'N’Guessan',
            'Gnahoré', 'Maguiraga', 'Kamissoko'
        ];

        foreach ($nomsDeFamilleMali as $nom) {
            $nomEntity = new Noms();
            $nomEntity->setDesignation($nom);
            $manager->persist($nomEntity);

            // Ajoutez un message de log (optionnel)
           // echo "Ajout du nom : $nom\n";

            // Utilisez le compteur pour créer une référence unique
            $this->setReference('nom_' . $this->counteur, $nomEntity);
            $this->counteur++; // Incrémentez le compteur
        }

        $manager->flush();
    }
}