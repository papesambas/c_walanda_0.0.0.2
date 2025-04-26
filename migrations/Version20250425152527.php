<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425152527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE parents ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', ADD slug VARCHAR(128) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parents ADD CONSTRAINT FK_FD501D6AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FD501D6AB03A8386 ON parents (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FD501D6A896DBBDE ON parents (updated_by_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6AB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FD501D6AB03A8386 ON parents
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FD501D6A896DBBDE ON parents
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parents DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug
        SQL);
    }
}
