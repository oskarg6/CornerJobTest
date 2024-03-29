<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Coffee;
use Doctrine\ORM\EntityManagerInterface;

/**
 * CoffeeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CoffeeRepository
{
    protected $entityManger;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManger = $entityManager;
    }

    /**
     * @param Coffee $coffee
     */
    public function save(Coffee $coffee)
    {
        $this->entityManger->persist($coffee);
        $this->entityManger->flush();
    }

    /**
     * @param Coffee $coffee
     */
    public function remove(Coffee $coffee)
    {
        $this->entityManger->remove($coffee);
        $this->entityManger->flush();
    }

    /**
     * @return array
     */
    public function getAllCoffees()
    {
        $builder = $this->entityManger->createQueryBuilder();

        $query = $builder->select('coffee')
            ->from('AppBundle:Coffee', 'coffee')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCoffeeById($id)
    {
        $builder = $this->entityManger->createQueryBuilder();

        $query = $builder->select('coffee')
            ->from('AppBundle:Coffee', 'coffee')
            ->where('coffee.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCoffeeByName($name)
    {
        $builder = $this->entityManger->createQueryBuilder();

        $query = $builder->select('coffee')
            ->from('AppBundle:Coffee', 'coffee')
            ->where('coffee.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
