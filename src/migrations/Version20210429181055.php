<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429181055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE drink_position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE drink_position (id INT NOT NULL, drink_id INT NOT NULL, ingredient_id INT NOT NULL, amount VARCHAR(100) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_8ED9112136AA4BB4 ON drink_position (drink_id)');
        $this->addSql('CREATE INDEX IDX_8ED91121933FE08C ON drink_position (ingredient_id)');
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT FK_8ED9112136AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE drink_position ADD CONSTRAINT FK_8ED91121933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE drink_position_id_seq CASCADE');
        $this->addSql('DROP TABLE drink_position');
    }
}
