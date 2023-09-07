<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323144352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party_drink DROP CONSTRAINT fk_127b607e213c1059');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_drink');
        $this->addSql('ALTER TABLE drink ALTER public DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE party (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, public BOOLEAN NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX idx_89954ee0a76ed395 ON party (user_id)');
        $this->addSql(
            'CREATE TABLE party_drink (party_id INT NOT NULL, drink_id INT NOT NULL, PRIMARY KEY(party_id, drink_id))'
        );
        $this->addSql('CREATE INDEX idx_127b607e36aa4bb4 ON party_drink (drink_id)');
        $this->addSql('CREATE INDEX idx_127b607e213c1059 ON party_drink (party_id)');
        $this->addSql(
            'ALTER TABLE party ADD CONSTRAINT fk_89954ee0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_drink ADD CONSTRAINT fk_127b607e213c1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE party_drink ADD CONSTRAINT fk_127b607e36aa4bb4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql('ALTER TABLE drink ALTER public SET DEFAULT \'false\'');
    }
}
