<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331212024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ALTER blog_status_id DROP DEFAULT');
        $this->addSql('ALTER TABLE blog ALTER blog_status_id DROP NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143CE89E8F2 FOREIGN KEY (blog_status_id) REFERENCES blog_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C0155143CE89E8F2 ON blog (blog_status_id)');
        $this->addSql('ALTER TABLE "user" ADD is_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER roles DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blog DROP CONSTRAINT FK_C0155143CE89E8F2');
        $this->addSql('DROP INDEX IDX_C0155143CE89E8F2');
        $this->addSql('ALTER TABLE blog ALTER blog_status_id SET DEFAULT 1');
        $this->addSql('ALTER TABLE blog ALTER blog_status_id SET NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP is_verified');
        $this->addSql('ALTER TABLE "user" ALTER roles SET NOT NULL');
    }
}
