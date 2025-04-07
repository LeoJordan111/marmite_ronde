<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407115705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, like_is TINYINT(1) DEFAULT NULL, update_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe_like (recipe_id INT NOT NULL, like_id INT NOT NULL, INDEX IDX_D3781A6C59D8A214 (recipe_id), INDEX IDX_D3781A6C859BFA32 (like_id), PRIMARY KEY(recipe_id, like_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_like ADD CONSTRAINT FK_D3781A6C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_like ADD CONSTRAINT FK_D3781A6C859BFA32 FOREIGN KEY (like_id) REFERENCES `like` (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_like DROP FOREIGN KEY FK_D3781A6C59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_like DROP FOREIGN KEY FK_D3781A6C859BFA32
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `like`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe_like
        SQL);
    }
}
