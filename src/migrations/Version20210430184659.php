<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430184659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drink_tag DROP CONSTRAINT fk_a46702ce36aa4bb4');
        $this->addSql('ALTER TABLE drink_position DROP CONSTRAINT fk_8ed9112136aa4bb4');
        $this->addSql('ALTER TABLE drink_position DROP CONSTRAINT fk_8ed91121933fe08c');
        $this->addSql('ALTER TABLE drink_tag DROP CONSTRAINT fk_a46702cebad26311');
        $this->addSql('DROP SEQUENCE ingredient_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drink_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drink_position_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql(
            'CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('DROP TABLE drink');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE drink_tag');
        $this->addSql('DROP TABLE drink_position');
        $this->addSql('DROP TABLE tag');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE ingredient_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drink_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drink_position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE drink (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, drinks_group VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE TABLE ingredient (id INT NOT NULL, name VARCHAR(100) NOT NULL, available BOOLEAN NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE TABLE drink_tag (drink_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(drink_id, tag_id))'
        );
        $this->addSql('CREATE INDEX idx_a46702ce36aa4bb4 ON drink_tag (drink_id)');
        $this->addSql('CREATE INDEX idx_a46702cebad26311 ON drink_tag (tag_id)');
        $this->addSql(
            'CREATE TABLE drink_position (id INT NOT NULL, drink_id INT NOT NULL, ingredient_id INT NOT NULL, amount VARCHAR(100) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX idx_8ed91121933fe08c ON drink_position (ingredient_id)');
        $this->addSql('CREATE INDEX idx_8ed9112136aa4bb4 ON drink_position (drink_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT fk_a46702ce36aa4bb4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT fk_a46702cebad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT fk_8ed9112136aa4bb4 FOREIGN KEY (drink_id) REFERENCES drink (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT fk_8ed91121933fe08c FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE "user"');
    }
}
