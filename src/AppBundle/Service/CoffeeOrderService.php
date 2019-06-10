<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 10/6/19
 * Time: 17:56
 */

namespace AppBundle\Service;


use AppBundle\Entity\Coffee;
use AppBundle\Entity\CoffeeOrder;
use AppBundle\Repository\ApiUserRepository;
use AppBundle\Repository\CoffeeOrderRepository;
use AppBundle\Repository\CoffeeRepository;
use Symfony\Component\HttpFoundation\Request;

class CoffeeOrderService
{
    protected  $orderRepository;
    protected $userRepository;
    protected $coffeeRepository;

    protected $coffeeService;

    function __construct(
        CoffeeOrderRepository $coffeeOrderRepository,
        ApiUserRepository $apiUserRepository,
        CoffeeRepository $coffeeRepository,
        CoffeeService $coffeeService
    )
    {
        $this->orderRepository = $coffeeOrderRepository;
        $this->userRepository = $apiUserRepository;
        $this->coffeeRepository = $coffeeRepository;
        $this->coffeeService = $coffeeService;
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function createOrder(Request $request)
    {
        $user = $this->userRepository->getUserByUsername($request->query->get('username'));
        $coffee = $this->coffeeRepository->getCoffeeByName($request->query->get('coffee'));

        if ($request->query->get('stock') <= $coffee->getStock()) {

            $order = new CoffeeOrder();
            $order->setAmount($this->calculateAmountOrder($coffee, $request->query->get('quantity')))
                ->setQuantity($request->query->get('quantity'))
                ->setApiUser($user)
                ->setCoffee($coffee);

            $this->orderRepository->save($order);

            $this->substractCoffeeStock($coffee, $order->getQuantity());

            return $order->toArray();
        }

        return false;
    }

    /**
     * @param Coffee $coffee
     * @param $quantity
     * @return float
     */
    private function calculateAmountOrder(Coffee $coffee, $quantity)
    {
        return $coffee->getPrice() * $quantity;
    }

    /**
     * @param Coffee $coffee
     * @param $quantity
     */
    private function substractCoffeeStock(Coffee $coffee, $quantity)
    {
        $newStock = $coffee->getStock() - $quantity;
        $this->coffeeService->changeCoffeeStock($coffee, $newStock);
    }

    /**
     * @return array
     */
    public function listOrders()
    {
        $orders = $this->orderRepository->getAllOrders();

        $ordersList = [];
        foreach ($orders as $order) {
            $ordersList[] = $order->toArray();
        }

        return $ordersList;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function updateOrder(Request $request)
    {
        if ($coffee = $this->coffeeRepository->getCoffeeByName($request->query->get('coffee'))) {

            $user = $this->userRepository->getUserByUsername($request->query->get('username'));

            if ($order = $this->orderRepository->getOrderByCoffeeAndUser($coffee, $user)) {
                if ($request->query->get('quantity')) {
                    $this->changeStockCoffee($order, $request->query->get('quantity'));

                    $order->setQuantity($request->query->get('quantity'));
                    $order->setAmount($this->calculateAmountOrder($coffee, $request->query->get('quantity')));

                    $this->orderRepository->save($order);

                    return $order->toArray();
                }
            }

        }

        return false;
    }

    /**
     * @param CoffeeOrder $order
     * @param $quantity
     */
    private function changeStockCoffee(CoffeeOrder $order, $quantity)
    {
        if ($order->getQuantity() > $quantity) {
            $quantityToAdd = $order->getQuantity() - $quantity;
            $this->addCoffeeStock($order->getCoffee(), $quantityToAdd);
        } else {
            $quantityToSubstract = $quantity - $order->getQuantity();
            $this->substractCoffeeStock($order->getCoffee(), $quantityToSubstract);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function deleteOrder(Request $request)
    {
        $orfer = $this->orderRepository->getOrderById($request->query->get('id'));

        $this->orderRepository->remove($orfer);

        $this->addCoffeeStock($orfer->getCoffee(), $orfer->getQuantity());

        return true;
    }

    /**
     * @param Coffee $coffee
     * @param $quantity
     */
    private function addCoffeeStock(Coffee $coffee, $quantity)
    {
        $newStock = $coffee->getStock() + $quantity;
        $this->coffeeService->changeCoffeeStock($coffee, $newStock);
    }

}