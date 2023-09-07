<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210905203901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE party (id INT NOT NULL, user_id INT NOT NULL, date DATE DEFAULT NULL, active BOOLEAN NOT NULL, hash VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_89954EE0A76ED395 ON party (user_id)');
        $this->addSql(
            'CREATE TABLE party_ingredient (party_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(party_id, ingredient_id))'
        );
        $this->addSql('CREATE INDEX IDX_63D4853C213C1059 ON party_ingredient (party_id)');
        $this->addSql('CREATE INDEX IDX_63D4853C933FE08C ON party_ingredient (ingredient_id)');
        $this->addSql(
            'ALTER TABLE party ADD CONSTRAINT FK_89954EE0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_ingredient ADD CONSTRAINT FK_63D4853C213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_ingredient ADD CONSTRAINT FK_63D4853C933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql('ALTER TABLE drink DROP drinks_group');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party_ingredient DROP CONSTRAINT FK_63D4853C213C1059');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_ingredient');
        $this->addSql('ALTER TABLE drink ADD drinks_group VARCHAR(50) DEFAULT NULL');
    }
}
