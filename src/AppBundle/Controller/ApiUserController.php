<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 9/6/19
 * Time: 14:34
 */

namespace AppBundle\Controller;


use AppBundle\Service\ApiUserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiUserController
{
    protected $userService;

    function __construct(ApiUserService $apiUserService)
    {
        $this->userService = $apiUserService;
    }

    public function createAdminAction(Request $request)
    {
        $user = $this->userService->createAdmin($request);

        $response = new Response(json_encode($user));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function createUserAction(Request $request)
    {
        $user = $this->userService->createUser($request);

        $response = new Response(json_encode($user));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}