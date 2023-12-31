<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Drink;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322204550 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $recipes = $em->getRepository(Drink::class)->findAll();

        /** @var Drink $recipe */
        foreach ($recipes as $recipe) {
            $recipe->setPublicId(Uuid::uuid4()->toString());
            $em->persist($recipe);
        }
        $em->flush();
        $this->addSql('ALTER TABLE drink alter column public_id set NOT NULL');
    }

    public function down(Schema $schema): void
    {
    }
}
