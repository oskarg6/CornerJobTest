<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 9/6/19
 * Time: 14:33
 */

namespace AppBundle\Controller;

use AppBundle\Service\ApiUserService;
use AppBundle\Service\CoffeeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoffeeController
{
    protected  $coffeeService;
    protected  $userService;

    function __construct(CoffeeService $coffeeService, ApiUserService $apiUserService)
    {
        $this->coffeeService = $coffeeService;
        $this->userService = $apiUserService;
    }

    public function createCoffeeAction(Request $request)
    {
        if ($this->userService->isValidAdminUser($request->query->get('username'), $request->query->get('password'))) {
            $coffee = $this->coffeeService->createCoffee($request);

            $response = new Response(json_encode($coffee));
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function listCoffeeAction()
    {
        $coffees = $this->coffeeService->listCoffee();

        $response = new Response(json_encode($coffees));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function updateCoffeeAction(Request $request)
    {
        if ($this->userService->isValidAdminUser($request->query->get('username'), $request->query->get('password'))) {
            $coffee = $this->coffeeService->updateCoffee($request);

            if ($coffee) {
                $response = new Response(json_encode($coffee));
            } else {
                $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid coffee or the user don\'t have order or not is set the quantity']));
            }
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function deleteCoffeeAction(Request $request)
    {
        if ($this->userService->isValidAdminUser($request->query->get('username'), $request->query->get('password'))) {
            $this->coffeeService->deleteCoffee($request);

            $response = new Response(json_encode(['status' => 'OK']));
        } else {
            $response = new Response(json_encode(['status' => 'ERROR', 'message' => 'invalid user']));
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}