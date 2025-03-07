<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307230228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE column_id_seq');
        $this->addSql('CREATE SEQUENCE column_id_seq');
        $this->addSql('SELECT setval(\'column_id_seq\', (SELECT MAX(id) FROM "column"))');
        $this->addSql('ALTER TABLE "column" ALTER id SET DEFAULT nextval(\'column_id_seq\')');

        $this->addSql('DROP SEQUENCE settings_show_team_id_seq');
        $this->addSql('CREATE SEQUENCE settings_show_team_id_seq');
        $this->addSql('SELECT setval(\'settings_show_team_id_seq\', (SELECT MAX(id) FROM settings_show_team))');
        $this->addSql('ALTER TABLE settings_show_team ALTER id SET DEFAULT nextval(\'settings_show_team_id_seq\')');

        $this->addSql('DROP SEQUENCE task_id_seq');
        $this->addSql('CREATE SEQUENCE task_id_seq');
        $this->addSql('SELECT setval(\'task_id_seq\', (SELECT MAX(id) FROM task))');
        $this->addSql('ALTER TABLE task ALTER id SET DEFAULT nextval(\'task_id_seq\')');

        $this->addSql('DROP SEQUENCE team_id_seq');
        $this->addSql('CREATE SEQUENCE team_id_seq');
        $this->addSql('SELECT setval(\'team_id_seq\', (SELECT MAX(id) FROM team))');
        $this->addSql('ALTER TABLE team ALTER id SET DEFAULT nextval(\'team_id_seq\')');

        $this->addSql('DROP SEQUENCE team_column_id_seq');
        $this->addSql('CREATE SEQUENCE team_column_id_seq');
        $this->addSql('SELECT setval(\'team_column_id_seq\', (SELECT MAX(id) FROM team_column))');
        $this->addSql('ALTER TABLE team_column ALTER id SET DEFAULT nextval(\'team_column_id_seq\')');

        $this->addSql('DROP SEQUENCE team_member_id_seq');
        $this->addSql('CREATE SEQUENCE team_member_id_seq');
        $this->addSql('SELECT setval(\'team_member_id_seq\', (SELECT MAX(id) FROM team_member))');
        $this->addSql('ALTER TABLE team_member ALTER id SET DEFAULT nextval(\'team_member_id_seq\')');

        $this->addSql('DROP SEQUENCE user_id_seq');
        $this->addSql('CREATE SEQUENCE user_id_seq');
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"))');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team_column ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team_member ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE settings_show_team ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "column" ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE task ALTER id DROP DEFAULT');
    }
}
