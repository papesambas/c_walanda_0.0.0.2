<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424205655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CE748AB03A8386 ON reset_password_request (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CE748A896DBBDE ON reset_password_request (updated_by_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748A896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7CE748AB03A8386 ON reset_password_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7CE748A896DBBDE ON reset_password_request
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP created_by_id, DROP updated_by_id
        SQL);
    }
}
