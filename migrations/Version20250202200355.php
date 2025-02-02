<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202200355 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "column" (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            teamId INT NOT NULL,
            type INT NOT NULL,
            createdAt TIMESTAMP DEFAULT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE "column"');
    }
}
