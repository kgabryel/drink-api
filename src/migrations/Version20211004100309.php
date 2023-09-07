<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004100309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party_ingredient DROP CONSTRAINT fk_63d4853c213c1059');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_ingredient');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE party (id INT NOT NULL, user_id INT NOT NULL, date DATE DEFAULT NULL, active BOOLEAN NOT NULL, hash VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX idx_89954ee0a76ed395 ON party (user_id)');
        $this->addSql(
            'CREATE TABLE party_ingredient (party_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(party_id, ingredient_id))'
        );
        $this->addSql('CREATE INDEX idx_63d4853c213c1059 ON party_ingredient (party_id)');
        $this->addSql('CREATE INDEX idx_63d4853c933fe08c ON party_ingredient (ingredient_id)');
        $this->addSql(
            'ALTER TABLE party ADD CONSTRAINT fk_89954ee0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_ingredient ADD CONSTRAINT fk_63d4853c213c1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_ingredient ADD CONSTRAINT fk_63d4853c933fe08c FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }
}
