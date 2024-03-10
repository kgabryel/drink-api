<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219183054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drinks_cards_available_drinks (drinks_card_id INT NOT NULL, drink_id INT NOT NULL, PRIMARY KEY(drinks_card_id, drink_id))');
        $this->addSql('CREATE INDEX IDX_F237978C92B4FF3E ON drinks_cards_available_drinks (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_F237978C36AA4BB4 ON drinks_cards_available_drinks (drink_id)');
        $this->addSql('CREATE TABLE drinks_cards_excluded_drinks (drinks_card_id INT NOT NULL, drink_id INT NOT NULL, PRIMARY KEY(drinks_card_id, drink_id))');
        $this->addSql('CREATE INDEX IDX_6B1C29092B4FF3E ON drinks_cards_excluded_drinks (drinks_card_id)');
        $this->addSql('CREATE INDEX IDX_6B1C29036AA4BB4 ON drinks_cards_excluded_drinks (drink_id)');
        $this->addSql('ALTER TABLE drinks_cards_available_drinks ADD CONSTRAINT FK_F237978C92B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_available_drinks ADD CONSTRAINT FK_F237978C36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_drinks ADD CONSTRAINT FK_6B1C29092B4FF3E FOREIGN KEY (drinks_card_id) REFERENCES drinks_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drinks_cards_excluded_drinks ADD CONSTRAINT FK_6B1C29036AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE drinks_cards_available_drinks');
        $this->addSql('DROP TABLE drinks_cards_excluded_drinks');
    }
}
