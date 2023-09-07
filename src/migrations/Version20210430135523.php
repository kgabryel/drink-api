<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430135523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE drink_tag (drink_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(drink_id, tag_id))'
        );
        $this->addSql('CREATE INDEX IDX_A46702CE36AA4BB4 ON drink_tag (drink_id)');
        $this->addSql('CREATE INDEX IDX_A46702CEBAD26311 ON drink_tag (tag_id)');
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT FK_A46702CE36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT FK_A46702CEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE drink_tag');
    }
}
