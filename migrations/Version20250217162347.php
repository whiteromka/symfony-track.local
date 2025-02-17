<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217162347 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('drop table if exists team_member');
        $this->addSql('CREATE TABLE "team_member" (
            id SERIAL PRIMARY KEY,
            team_id INT NOT NULL,
            user_id INT NOT NULL,
            is_captain BOOLEAN NOT NULL DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table if exists team_member');
    }
}
