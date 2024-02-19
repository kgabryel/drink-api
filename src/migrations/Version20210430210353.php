<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430210353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE drink_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drink_position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ingredient_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE drink (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, drinks_group VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_DBE40D1A76ED395 ON drink (user_id)');
        $this->addSql(
            'CREATE TABLE drink_tag (drink_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(drink_id, tag_id))'
        );
        $this->addSql('CREATE INDEX IDX_A46702CE36AA4BB4 ON drink_tag (drink_id)');
        $this->addSql('CREATE INDEX IDX_A46702CEBAD26311 ON drink_tag (tag_id)');
        $this->addSql(
            'CREATE TABLE drink_position (id INT NOT NULL, drink_id INT NOT NULL, ingredient_id INT NOT NULL, amount VARCHAR(100) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_8ED9112136AA4BB4 ON drink_position (drink_id)');
        $this->addSql('CREATE INDEX IDX_8ED91121933FE08C ON drink_position (ingredient_id)');
        $this->addSql(
            'CREATE TABLE ingredient (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(100) NOT NULL, available BOOLEAN NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_6BAF7870A76ED395 ON ingredient (user_id)');
        $this->addSql(
            'CREATE TABLE tag (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
        $this->addSql(
            'ALTER TABLE drink ADD CONSTRAINT FK_DBE40D1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT FK_A46702CE36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_tag ADD CONSTRAINT FK_A46702CEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT FK_8ED9112136AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT FK_8ED91121933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE tag ADD CONSTRAINT FK_389B783A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE drink_tag DROP CONSTRAINT FK_A46702CE36AA4BB4');
        $this->addSql('ALTER TABLE drink_position DROP CONSTRAINT FK_8ED9112136AA4BB4');
        $this->addSql('ALTER TABLE drink_position DROP CONSTRAINT FK_8ED91121933FE08C');
        $this->addSql('ALTER TABLE drink_tag DROP CONSTRAINT FK_A46702CEBAD26311');
        $this->addSql('DROP SEQUENCE drink_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drink_position_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ingredient_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP TABLE drink');
        $this->addSql('DROP TABLE drink_tag');
        $this->addSql('DROP TABLE drink_position');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE tag');
    }
}
