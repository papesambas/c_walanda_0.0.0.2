<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424172443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cercles (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_45C1718D98260155 (region_id), INDEX IDX_45C1718DB03A8386 (created_by_id), INDEX IDX_45C1718D896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE communes (id INT AUTO_INCREMENT NOT NULL, cercle_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_5C5EE2A527413AB9 (cercle_id), INDEX IDX_5C5EE2A5B03A8386 (created_by_id), INDEX IDX_5C5EE2A5896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE lieu_naissances (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_49F8927FB03A8386 (created_by_id), INDEX IDX_49F8927F896DBBDE (updated_by_id), INDEX idx_lieu_naissances_designation (designation), INDEX idx_lieu_naissances_commune (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE noms (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_A069E65DB03A8386 (created_by_id), INDEX IDX_A069E65D896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_NOM (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE prenoms (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(75) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_E71162E3B03A8386 (created_by_id), INDEX IDX_E71162E3896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_PRENOM (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE professions (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_2FDA85FAB03A8386 (created_by_id), INDEX IDX_2FDA85FA896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_PROFESSION (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_A26779F3B03A8386 (created_by_id), INDEX IDX_A26779F3896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_REGION (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', expires_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(75) NOT NULL, email VARCHAR(255) NOT NULL, is_actif TINYINT(1) NOT NULL, is_allowed TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_1483A5E9B03A8386 (created_by_id), INDEX IDX_1483A5E9896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D98260155 FOREIGN KEY (region_id) REFERENCES regions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles ADD CONSTRAINT FK_45C1718DB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A527413AB9 FOREIGN KEY (cercle_id) REFERENCES cercles (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A5B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A5896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927FB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE noms ADD CONSTRAINT FK_A069E65DB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE noms ADD CONSTRAINT FK_A069E65D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prenoms ADD CONSTRAINT FK_E71162E3B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prenoms ADD CONSTRAINT FK_E71162E3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professions ADD CONSTRAINT FK_2FDA85FAB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professions ADD CONSTRAINT FK_2FDA85FA896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE regions ADD CONSTRAINT FK_A26779F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE regions ADD CONSTRAINT FK_A26779F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD CONSTRAINT FK_1483A5E9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D98260155
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718DB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A527413AB9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A5B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A5896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F131A4F72
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927FB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE noms DROP FOREIGN KEY FK_A069E65DB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE noms DROP FOREIGN KEY FK_A069E65D896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prenoms DROP FOREIGN KEY FK_E71162E3B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prenoms DROP FOREIGN KEY FK_E71162E3896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professions DROP FOREIGN KEY FK_2FDA85FAB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professions DROP FOREIGN KEY FK_2FDA85FA896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE regions DROP FOREIGN KEY FK_A26779F3B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE regions DROP FOREIGN KEY FK_A26779F3896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cercles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE communes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE lieu_naissances
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE noms
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE prenoms
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE professions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE regions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reset_password_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
