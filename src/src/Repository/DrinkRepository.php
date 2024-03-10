<?php

namespace App\Repository;

use App\Entity\Drink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Drink|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drink|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drink[]    findAll()
 * @method Drink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkRepository extends ServiceEntityRepository
{
    use FindTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drink::class);
    }

    public function findForCard(string $drinksCardId): array
    {
        $subqueryMapping = new ResultSetMapping();
        $availableTagsQuery = $this->_em->createNativeQuery(
            '
                select drink_tag.drink_id from drinks_cards_available_tags
                    inner join drinks_card on drinks_cards_available_tags.drinks_card_id = drinks_card.id
                    inner join drink_tag on drink_tag.tag_id = drinks_cards_available_tags.tag_id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $excludedTagsQuery = $this->_em->createNativeQuery(
            '
                select drink_tag.drink_id from drinks_cards_excluded_tags
                    inner join drinks_card on drinks_cards_excluded_tags.drinks_card_id = drinks_card.id
                    inner join drink_tag on drink_tag.tag_id = drinks_cards_excluded_tags.tag_id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $availableIngredientsQuery = $this->_em->createNativeQuery(
            '
                select drink_position.drink_id from drinks_cards_available_ingredients
                    inner join drinks_card on drinks_cards_available_ingredients.drinks_card_id = drinks_card.id
                    inner join drink_position on drink_position.ingredient_id = drinks_cards_available_ingredients.ingredient_id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $excludedIngredientsQuery = $this->_em->createNativeQuery(
            '
                select drink_position.drink_id from drinks_cards_excluded_ingredients
                    inner join drinks_card on drinks_cards_excluded_ingredients.drinks_card_id = drinks_card.id
                    inner join drink_position on drink_position.ingredient_id = drinks_cards_excluded_ingredients.ingredient_id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $availableDrinksQuery = $this->_em->createNativeQuery(
            '
                select drinks_cards_available_drinks.drink_id from drinks_cards_available_drinks
                    inner join drinks_card on drinks_cards_available_drinks.drinks_card_id = drinks_card.id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $excludedDrinksQuery = $this->_em->createNativeQuery(
            '
                select drinks_cards_excluded_drinks.drink_id from drinks_cards_excluded_drinks
                    inner join drinks_card on drinks_cards_excluded_drinks.drinks_card_id = drinks_card.id
                    where drinks_card.public_id = ?
            ',
            $subqueryMapping
        );
        $drinkMapping = new ResultSetMapping();
        $drinkMapping->addEntityResult(Drink::class, 'd');
        $drinkMapping->addFieldResult('d', 'id', 'id');
        $drinkMapping->addFieldResult('d', 'name', 'name');
        $drinkMapping->addFieldResult('d', 'description', 'description');

        return $this->_em->createNativeQuery(
            sprintf(
                '
                select id, name, description
                    from drink
                    where 
                        (drink.id in (%s) or drink.id in (%s) or drink.id in (%s)) and
                        drink.id not in (%s) and
                        drink.id not in (%s) and
                        drink.id not in (%s)
                    order by drink.id
                ',
                $availableDrinksQuery->getSQL(),
                $availableTagsQuery->getSQL(),
                $availableIngredientsQuery->getSQL(),
                $excludedDrinksQuery->getSQL(),
                $excludedTagsQuery->getSQL(),
                $excludedIngredientsQuery->getSQL()
            ),
            $drinkMapping
        )->setParameter(1, $drinksCardId)
            ->setParameter(2, $drinksCardId)
            ->setParameter(3, $drinksCardId)
            ->setParameter(4, $drinksCardId)
            ->setParameter(5, $drinksCardId)
            ->setParameter(6, $drinksCardId)
            ->getResult();
    }

    public function existsInCard(int $drinkId): bool
    {
        $subqueryMapping = new ResultSetMapping();
        $availableTagsQuery = $this->_em->createNativeQuery(
            '
            select drink_tag.drink_id
            from drinks_cards_available_tags
            inner join drinks_card on drinks_cards_available_tags.drinks_card_id = drinks_card.id
            inner join drink_tag on drink_tag.tag_id = drinks_cards_available_tags.tag_id
            where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $excludedTagsQuery = $this->_em->createNativeQuery(
            '
            select drink_position.drink_id
            from drinks_cards_excluded_ingredients
            inner join drinks_card on drinks_cards_excluded_ingredients.drinks_card_id = drinks_card.id
            inner join drink_position on drink_position.ingredient_id = drinks_cards_excluded_ingredients.ingredient_id
            where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $availableIngredientsQuery = $this->_em->createNativeQuery(
            '
            select drink_position.drink_id
            from drinks_cards_available_ingredients
            inner join drinks_card on drinks_cards_available_ingredients.drinks_card_id = drinks_card.id
            inner join drink_position on drink_position.ingredient_id = drinks_cards_available_ingredients.ingredient_id
            where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $excludedIngredientsQuery = $this->_em->createNativeQuery(
            '
            select drink_position.drink_id
            from drinks_cards_excluded_ingredients
            inner join drinks_card on drinks_cards_excluded_ingredients.drinks_card_id = drinks_card.id
            inner join drink_position  on drink_position.ingredient_id = drinks_cards_excluded_ingredients.ingredient_id
            where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $availableDrinksQuery = $this->_em->createNativeQuery(
            '
                select drinks_cards_available_drinks.drink_id from drinks_cards_available_drinks
                    inner join drinks_card on drinks_cards_available_drinks.drinks_card_id = drinks_card.id
                    where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $excludedDrinksQuery = $this->_em->createNativeQuery(
            '
                select drinks_cards_excluded_drinks.drink_id from drinks_cards_excluded_drinks
                    inner join drinks_card on drinks_cards_excluded_drinks.drinks_card_id = drinks_card.id
                    where drinks_card.id = dc.id
            ',
            $subqueryMapping
        );
        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addScalarResult('x', 'x', 'boolean');
        $query = $this->_em
            ->createNativeQuery(
                sprintf(
                    '
                    select exists
                    (select 1 from
                        (select x from drinks_card dc
                        left join lateral
                        (select exists
                            (select 1 from drink
                                where drink.id = ? and
                                (drink.id in (%s) or drink.id in (%s) or drink.id in (%s)) and
                                drink.id not in (%s) and
                                drink.id not in (%s) and
                                drink.id not in (%s)) as x) test on true
                                where dc.active ) main
                        where main.x) as x
                    ',
                    $availableDrinksQuery->getSQL(),
                    $availableTagsQuery->getSQL(),
                    $availableIngredientsQuery->getSQL(),
                    $excludedDrinksQuery->getSQL(),
                    $excludedTagsQuery->getSQL(),
                    $excludedIngredientsQuery->getSQL()
                ),
                $rsm
            );
        $query->setParameter(1, $drinkId);

        return (bool)$query
            ->getSingleScalarResult();
    }
}
