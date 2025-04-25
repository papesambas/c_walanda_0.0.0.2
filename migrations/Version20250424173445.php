<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424173445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_cercles_designation ON cercles (designation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles RENAME INDEX idx_45c1718d98260155 TO idx_cercles_commune
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_communes_designation ON communes (designation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes RENAME INDEX idx_5c5ee2a527413ab9 TO idx_communes_commune
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX idx_cercles_designation ON cercles
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cercles RENAME INDEX idx_cercles_commune TO IDX_45C1718D98260155
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_communes_designation ON communes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE communes RENAME INDEX idx_communes_commune TO IDX_5C5EE2A527413AB9
        SQL);
    }
}
