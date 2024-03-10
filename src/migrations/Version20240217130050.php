<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217130050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE drinks_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE drinks_card (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, public_id VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C583FC20B5B48B91 ON drinks_card (public_id)');
        $this->addSql('CREATE INDEX IDX_C583FC20A76ED395 ON drinks_card (user_id)');
        $this->addSql('CREATE TABLE drinks_cards_available_tags (drinks_card_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(drinks_card_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_44FB665292B4FF3E ON drinks_cards_available_tags (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_44FB6652BAD26311 ON drinks_cards_available_tags (tag_id)');
        $this->addSql('CREATE TABLE drinks_cards_excluded_tags (drinks_card_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(drinks_card_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_CC5446E192B4FF3E ON drinks_cards_excluded_tags (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_CC5446E1BAD26311 ON drinks_cards_excluded_tags (tag_id)');
        $this->addSql('CREATE TABLE drinks_cards_available_ingredients (drinks_card_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(drinks_card_id, ingredient_id))');
        $this->addSql('CREATE INDEX IDX_96FDF10392B4FF3E ON drinks_cards_available_ingredients (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_96FDF103933FE08C ON drinks_cards_available_ingredients (ingredient_id)');
        $this->addSql('CREATE TABLE drinks_cards_excluded_ingredients (drinks_card_id INT NOT NULL, ingredient_id INT NOT NULL, PRIMARY KEY(drinks_card_id, ingredient_id))');
        $this->addSql('CREATE INDEX IDX_5A56379B92B4FF3E ON drinks_cards_excluded_ingredients (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_5A56379B933FE08C ON drinks_cards_excluded_ingredients (ingredient_id)');
        $this->addSql('ALTER TABLE drinks_card ADD CONSTRAINT FK_C583FC20A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_available_tags ADD CONSTRAINT FK_44FB665292B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_available_tags ADD CONSTRAINT FK_44FB6652BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_tags ADD CONSTRAINT FK_CC5446E192B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_tags ADD CONSTRAINT FK_CC5446E1BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_available_ingredients ADD CONSTRAINT FK_96FDF10392B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_available_ingredients ADD CONSTRAINT FK_96FDF103933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_ingredients ADD CONSTRAINT FK_5A56379B92B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_ingredients ADD CONSTRAINT FK_5A56379B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE drinks_cards_available_tags DROP CONSTRAINT FK_44FB665292B4FF3E');
        $this->addSql('ALTER TABLE drinks_cards_excluded_tags DROP CONSTRAINT FK_CC5446E192B4FF3E');
        $this->addSql('ALTER TABLE drinks_cards_available_ingredients DROP CONSTRAINT FK_96FDF10392B4FF3E');
        $this->addSql('ALTER TABLE drinks_cards_excluded_ingredients DROP CONSTRAINT FK_5A56379B92B4FF3E');
        $this->addSql('DROP SEQUENCE drinks_card_id_seq CASCADE');
        $this->addSql('DROP TABLE drinks_card');
        $this->addSql('DROP TABLE drinks_cards_available_tags');
        $this->addSql('DROP TABLE drinks_cards_excluded_tags');
        $this->addSql('DROP TABLE drinks_cards_available_ingredients');
        $this->addSql('DROP TABLE drinks_cards_excluded_ingredients');
    }
}
