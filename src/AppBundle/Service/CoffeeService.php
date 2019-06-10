<?php
namespace AppBundle\Service;

use AppBundle\Entity\Coffee;
use AppBundle\Repository\CoffeeRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 10/6/19
 * Time: 0:42
 */
class CoffeeService
{
    protected  $coffeeRepository;

    function __construct(CoffeeRepository $coffeeRepository)
    {
        $this->coffeeRepository = $coffeeRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createCoffee(Request $request)
    {
        $coffee = new Coffee();
        $coffee->setName($request->query->get('name'))
            ->setIntensity($request->query->get('intensity'))
            ->setPrice($request->query->get('price'))
            ->setStock($request->query->get('stock'));

        $this->coffeeRepository->save($coffee);

        return $coffee->toArray();
    }

    /**
     * @return array
     */
    public function listCoffee()
    {
        $coffees = $this->coffeeRepository->getAllCoffees();

        $coffeesList = [];
        foreach ($coffees as $coffee) {
            $coffeesList[] = $coffee->toArray();
        }

        return $coffeesList;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function updateCoffee(Request $request)
    {
        if ($request->query->get('id')) {
            if ($coffee = $this->coffeeRepository->getCoffeeById($request->query->get('id'))) {

                if ($request->query->get('name')) {
                    $coffee->setName($request->query->get('name'));
                }
                if ($request->query->get('intensity')) {
                    $coffee->setIntensity($request->query->get('intensity'));
                }
                if ($request->query->get('price')) {
                    $coffee->setPrice($request->query->get('price'));
                }
                if ($request->query->get('stock')) {
                    $coffee->setStock($request->query->get('stock'));
                }

                $this->coffeeRepository->save($coffee);

                return $coffee->toArray();
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function deleteCoffee(Request $request)
    {
        $coffee = $this->coffeeRepository->getCoffeeById($request->query->get('id'));

        $this->coffeeRepository->remove($coffee);

        return true;
    }
}