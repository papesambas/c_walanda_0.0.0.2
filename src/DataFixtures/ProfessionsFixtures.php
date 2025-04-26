<?php

namespace App\DataFixtures;

use App\Entity\Professions;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfessionsFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counteur = 0; // Compteur pour les références

    public function load(ObjectManager $manager): void
    {
        $professions = [
            'Agriculteur','Éleveur','Pêcheur','Commerçant','Artisan','Menuisier','Forgeron','Tailleur',
            'Couturier','Coiffeur','Infirmier','Médecin','Enseignant','Professeur','Ingénieur',
            'Architecte','Technicien','Électricien','Plombier','Mécanicien','Chauffeur','Conducteur',
            'Vendeur','Comptable','Banquier','Secrétaire','Agent administratif','Journaliste',
            'Écrivain','Artiste','Musicien','Danseur','Acteur','Photographe','Cuisinier','Restaurateur',
            'Hôtelier','Guide touristique','Agent de voyage','Informaticien','Développeur','Designer',
            'Consultant','Avocat','Juge','Policier','Militaire','Pompier','Agent de sécurité','Agent immobilier',
            'Agent commercial','Représentant','Distributeur','Transporteur','Logisticien','Magasinier',
            'Ouvrier','Manutentionnaire','Charpentier','Maçon','Peintre','Plâtrier','Carreleur','Jardinier',
            'Paysagiste','Vétérinaire','Pharmacien','Sage-femme','Aide-soignant','Chirurgien','Dentiste',
            'Psychologue','Sociologue','Économiste','Chercheur','Scientifique','Biologiste','Chimiste',
            'Physicien','Astronome','Géologue','Archéologue','Historien','Traducteur','Interprète','Bibliothécaire',
            'Documentaliste','Archiviste','Éditeur','Imprimeur','Libraire','Relieur','Graphiste','Publicitaire',
            'Marketing','Community Manager','Influenceur','Blogueur','Youtuber','Podcasteur','Monteur vidéo',
            'Réalisateur','Producteur','Scénariste','Doubleur','Cascadeur','Stuntman','Vidéaste','DJ',
            'Chanteur','Chorégraphe','Sculpteur','Céramiste','Potier','Tisserand','Bijoutier','Horloger',
            'Cordonnier','Maroquinier','Tanneur','Boucher','Boulanger','Pâtissier','Fromager','Poissonnier',
            'Primeur','Épicier','Caviste','Sommelier','Barista','Serveur','Barman','Hôte d\'accueil','Réceptionniste',
            'Concierge','Femme de ménage','Agent d\'entretien','Garde forestier','Gardien','Surveillant',
            'Ambulancier','Secouriste','Sapeur-pompier','Gendarme','Douanier','Inspecteur','Enquêteur',
            'Détective','Espion','Agent secret','Diplomate','Ambassadeur','Consul','Attaché','Conseiller',
            'Ministre','Président','Gouverneur','Maire','Conseiller municipal','Député','Sénateur',
            'Procureur','Greffier','Huissier','Notaire','Commissaire-priseur','Expert-comptable','Auditeur',
            'Contrôleur de gestion','Analyste financier','Trader','Courtier','Assureur','Conseiller financier',
            'Gestionnaire de patrimoine','Promoteur immobilier','Urbaniste','Géomètre','Topographe','Cartographe',
            'Pilote','Capitaine','Marin','Navigateur','Contrôleur aérien','Hôtesse de l\'air','Steward',
            'Agent de bord','Chef de cabine','Chef de gare','Conducteur de train','Aiguilleur','Ingénieur ferroviaire',
            'Ingénieur aéronautique','Ingénieur naval','Ingénieur automobile','Ingénieur civil','Ingénieur en génie électrique',
            'Ingénieur en génie mécanique','Ingénieur en génie chimique','Ingénieur en génie industriel',
            'Ingénieur en génie logiciel','Ingénieur en génie biomédical','Ingénieur en génie agricole',
            'Ingénieur en génie environnemental','Ingénieur en génie pétrolier','Ingénieur en génie minier',
            'Ingénieur en génie nucléaire'
        ];

        foreach ($professions as $profession) {
            $professionEntity = new Professions();
            $professionEntity->setDesignation($profession);
            $manager->persist($professionEntity);

            // Utilisez le compteur pour créer une référence unique
            $this->setReference('profession_' . $this->counteur, $professionEntity);
            $this->counteur++; // Incrémentez le compteur

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PrenomsFixtures::class
        ];
    }
}
