<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 9/6/19
 * Time: 14:34
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ApiUser;
use AppBundle\Repository\ApiUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiUserController
{
    const ADMIN_ROLE_USER = 'ADMIN';
    const NORMAL_ROLE_USER = 'USER';

    protected $userRepository;

    function __construct(ApiUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createAdminAction(Request $request)
    {
        $user = new ApiUser();
        $user->setUsername($request->query->get('username'));
        $user->setPassword(password_hash($request->query->get('password'), PASSWORD_DEFAULT));
        $user->setRole(self::ADMIN_ROLE_USER);

        $this->userRepository->save($user);

        $response = new Response(json_encode($user->toArray()));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function createUserAction(Request $request)
    {
        $user = new ApiUser();
        $user->setUsername($request->query->get('username'));
        $user->setPassword(password_hash($request->query->get('password'), PASSWORD_DEFAULT));
        $user->setRole(self::NORMAL_ROLE_USER);

        $this->userRepository->save($user);

        $response = new Response(json_encode($user->toArray()));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}