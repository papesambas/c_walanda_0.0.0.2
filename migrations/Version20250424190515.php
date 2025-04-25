<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424190515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE meres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, nina_id INT DEFAULT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D8B408A5586F33C (nina_id), UNIQUE INDEX UNIQ_2D8B408A9420D165 (telephone1_id), UNIQUE INDEX UNIQ_2D8B408A86957E8B (telephone2_id), INDEX idx_meres_nom (nom_id), INDEX idx_meres_prenom (prenom_id), INDEX idx_meres_profession (profession_id), INDEX idx_meres_nina (nina_id), INDEX idx_meres_telephone1 (telephone1_id), INDEX idx_meres_telephone2 (telephone2_id), INDEX idx_meres_email (email), INDEX idx_meres_fullname (fullname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE peres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, nina_id INT DEFAULT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_B5FB13B95586F33C (nina_id), UNIQUE INDEX UNIQ_B5FB13B99420D165 (telephone1_id), UNIQUE INDEX UNIQ_B5FB13B986957E8B (telephone2_id), INDEX IDX_B5FB13B9B03A8386 (created_by_id), INDEX IDX_B5FB13B9896DBBDE (updated_by_id), INDEX idx_peres_nom (nom_id), INDEX idx_peres_prenom (prenom_id), INDEX idx_peres_profession (profession_id), INDEX idx_peres_nina (nina_id), INDEX idx_peres_telephone1 (telephone1_id), INDEX idx_peres_telephone2 (telephone2_id), INDEX idx_peres_fullname (fullname), INDEX idx_peres_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AC8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A58819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AFDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A5586F33C FOREIGN KEY (nina_id) REFERENCES ninas (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A9420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A86957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9C8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B958819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9FDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B95586F33C FOREIGN KEY (nina_id) REFERENCES ninas (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B99420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B986957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AC8121CE9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A58819F9E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AFDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A5586F33C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A9420D165
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A86957E8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9C8121CE9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B958819F9E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B95586F33C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B99420D165
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B986957E8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE meres
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE peres
        SQL);
    }
}
