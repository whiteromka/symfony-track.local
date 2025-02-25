<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224232547 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('alter table blog add column category_id int not null');
        $this->addSql('alter table blog add constraint fk_blog__category_id foreign key (category_id) references category(id)');
        $this->addSql('create index idx_blog__category_id on blog(category_id)');
    }

    public function down(Schema $schema): void
    {
       return;
    }
}
