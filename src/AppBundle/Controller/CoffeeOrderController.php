<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 9/6/19
 * Time: 14:34
 */

namespace AppBundle\Controller;


use AppBundle\Service\ApiUserService;
use AppBundle\Service\CoffeeOrderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoffeeOrderController
{
    protected $orederService;
    protected $userService;

    function __construct(CoffeeOrderService $coffeeOrderService, ApiUserService $apiUserService)
    {
        $this->orederService = $coffeeOrderService;
        $this->userService = $apiUserService;
    }

    public function createOrderAction(Request $request)
    {
        if ($this->userService->isValidUser($request->query->get('username'), $request->query->get('password'))) {
            $order = $this->orederService->createOrder($request);
            if ($order) {
                $response = new Response(json_encode($order));
            } else {
                $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'no stock']));
            }
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function listOrdersAction()
    {
        $orders = $this->orederService->listOrders();

        $response = new Response(json_encode($orders));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function updateOrderAction(Request $request)
    {
        if ($this->userService->isValidUser($request->query->get('username'), $request->query->get('password'))) {
            $order = $this->orederService->updateOrder($request);

            if ($order) {
                $response = new Response(json_encode($order));
            } else {
                $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid coffee id']));
            }
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function deleteOrderAction(Request $request)
    {
        if ($this->userService->isValidUser($request->query->get('username'), $request->query->get('password'))) {
            $this->orederService->deleteOrder($request);

            $response = new Response(json_encode(['status' => 'OK']));
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}