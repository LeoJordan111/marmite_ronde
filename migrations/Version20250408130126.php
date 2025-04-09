<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408130126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD difficulty_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DA88B137FCFA9DAE ON recipe (difficulty_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137FCFA9DAE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DA88B137FCFA9DAE ON recipe
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP difficulty_id
        SQL);
    }
}
