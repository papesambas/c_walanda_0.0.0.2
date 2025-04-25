<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424183625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ninas (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, numero VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_51AD1AF2B03A8386 (created_by_id), INDEX IDX_51AD1AF2896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_NINA (numero), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE telephones1 (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, numero VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_E36A9DB2B03A8386 (created_by_id), INDEX IDX_E36A9DB2896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_NUMERO (numero), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE telephones2 (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, numero VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', slug VARCHAR(128) NOT NULL, INDEX IDX_7A63CC08B03A8386 (created_by_id), INDEX IDX_7A63CC08896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_IDENTIFIER_NUMERO (numero), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF2B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones1 ADD CONSTRAINT FK_E36A9DB2B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones1 ADD CONSTRAINT FK_E36A9DB2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones2 ADD CONSTRAINT FK_7A63CC08B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones2 ADD CONSTRAINT FK_7A63CC08896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF2B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF2896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones1 DROP FOREIGN KEY FK_E36A9DB2B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones1 DROP FOREIGN KEY FK_E36A9DB2896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones2 DROP FOREIGN KEY FK_7A63CC08B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE telephones2 DROP FOREIGN KEY FK_7A63CC08896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ninas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE telephones1
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE telephones2
        SQL);
    }
}
