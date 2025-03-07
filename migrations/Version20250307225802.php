<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307225802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE blog_id_seq');
        $this->addSql('CREATE SEQUENCE blog_id_seq');
        $this->addSql('SELECT setval(\'blog_id_seq\', (SELECT MAX(id) FROM blog))');
        $this->addSql('ALTER TABLE blog ALTER id SET DEFAULT nextval(\'blog_id_seq\')');

        $this->addSql('DROP SEQUENCE category_id_seq');
        $this->addSql('CREATE SEQUENCE category_id_seq');
        $this->addSql('SELECT setval(\'category_id_seq\', (SELECT MAX(id) FROM category))');
        $this->addSql('ALTER TABLE category ALTER id SET DEFAULT nextval(\'category_id_seq\')');

        $this->addSql('DROP SEQUENCE tag_id_seq');
        $this->addSql('CREATE SEQUENCE tag_id_seq');
        $this->addSql('SELECT setval(\'tag_id_seq\', (SELECT MAX(id) FROM tag))');
        $this->addSql('ALTER TABLE tag ALTER id SET DEFAULT nextval(\'tag_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE blog ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE tag ALTER id DROP DEFAULT');
    }
}
