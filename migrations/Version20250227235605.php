<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227235605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE task_id_seq1 CASCADE');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tag_to_blog (blog_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(blog_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_15CA6D26DAE07E97 ON tag_to_blog (blog_id)');
        $this->addSql('CREATE INDEX IDX_15CA6D26BAD26311 ON tag_to_blog (tag_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE tag_to_blog ADD CONSTRAINT FK_15CA6D26DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_to_blog ADD CONSTRAINT FK_15CA6D26BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE blog ALTER category_id DROP NOT NULL');
        $this->addSql('ALTER TABLE blog ALTER description SET NOT NULL');
        $this->addSql('ALTER INDEX idx_blog__category_id RENAME TO IDX_C015514312469DE2');
        $this->addSql('ALTER TABLE category ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "column" ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "column" RENAME COLUMN createdat TO created_at');
        $this->addSql('ALTER TABLE settings_show_team ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE settings_show_team ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE task ALTER id TYPE INT');
        $this->addSql('ALTER TABLE task ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE task ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE team ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team_column ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team_member ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE team_member ALTER is_captain DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE task_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE tag_to_blog DROP CONSTRAINT FK_15CA6D26DAE07E97');
        $this->addSql('ALTER TABLE tag_to_blog DROP CONSTRAINT FK_15CA6D26BAD26311');
        $this->addSql('DROP TABLE tag_to_blog');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE task ALTER id TYPE BIGINT');
        $this->addSql('CREATE SEQUENCE task_id_seq');
        $this->addSql('SELECT setval(\'task_id_seq\', (SELECT MAX(id) FROM task))');
        $this->addSql('ALTER TABLE task ALTER id SET DEFAULT nextval(\'task_id_seq\')');
        $this->addSql('ALTER TABLE task ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('CREATE SEQUENCE team_member_id_seq');
        $this->addSql('SELECT setval(\'team_member_id_seq\', (SELECT MAX(id) FROM team_member))');
        $this->addSql('ALTER TABLE team_member ALTER id SET DEFAULT nextval(\'team_member_id_seq\')');
        $this->addSql('ALTER TABLE team_member ALTER is_captain SET DEFAULT false');
        $this->addSql('CREATE SEQUENCE settings_show_team_id_seq');
        $this->addSql('SELECT setval(\'settings_show_team_id_seq\', (SELECT MAX(id) FROM settings_show_team))');
        $this->addSql('ALTER TABLE settings_show_team ALTER id SET DEFAULT nextval(\'settings_show_team_id_seq\')');
        $this->addSql('ALTER TABLE settings_show_team ALTER created_at DROP NOT NULL');
        $this->addSql('CREATE SEQUENCE user_id_seq');
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"))');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');
        $this->addSql('CREATE SEQUENCE team_column_id_seq');
        $this->addSql('SELECT setval(\'team_column_id_seq\', (SELECT MAX(id) FROM team_column))');
        $this->addSql('ALTER TABLE team_column ALTER id SET DEFAULT nextval(\'team_column_id_seq\')');
        $this->addSql('CREATE SEQUENCE team_id_seq');
        $this->addSql('SELECT setval(\'team_id_seq\', (SELECT MAX(id) FROM team))');
        $this->addSql('ALTER TABLE team ALTER id SET DEFAULT nextval(\'team_id_seq\')');
        $this->addSql('CREATE SEQUENCE category_id_seq');
        $this->addSql('SELECT setval(\'category_id_seq\', (SELECT MAX(id) FROM category))');
        $this->addSql('ALTER TABLE category ALTER id SET DEFAULT nextval(\'category_id_seq\')');
        $this->addSql('CREATE SEQUENCE column_id_seq');
        $this->addSql('SELECT setval(\'column_id_seq\', (SELECT MAX(id) FROM "column"))');
        $this->addSql('ALTER TABLE "column" ALTER id SET DEFAULT nextval(\'column_id_seq\')');
        $this->addSql('ALTER TABLE "column" RENAME COLUMN created_at TO createdat');
        $this->addSql('CREATE SEQUENCE blog_id_seq');
        $this->addSql('SELECT setval(\'blog_id_seq\', (SELECT MAX(id) FROM blog))');
        $this->addSql('ALTER TABLE blog ALTER id SET DEFAULT nextval(\'blog_id_seq\')');
        $this->addSql('ALTER TABLE blog ALTER category_id SET NOT NULL');
        $this->addSql('ALTER TABLE blog ALTER description DROP NOT NULL');
        $this->addSql('ALTER INDEX idx_c015514312469de2 RENAME TO idx_blog__category_id');
    }
}
