<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 10/6/19
 * Time: 10:09
 */

namespace AppBundle\Service;


use AppBundle\Entity\ApiUser;
use AppBundle\Repository\ApiUserRepository;
use Symfony\Component\HttpFoundation\Request;

class ApiUserService
{
    const ADMIN_ROLE_USER = 'ADMIN';
    const NORMAL_ROLE_USER = 'USER';

    protected $userRepository;

    function __construct(ApiUserRepository $apiUserRepository)
    {
        $this->userRepository = $apiUserRepository;
    }

    public function isValidAdminUser($username, $password)
    {
        $user = $this->userRepository->getUserByUsername($username);

        if (
            !empty($user)
            && $this->verifyPasswordHash($password, $user->getPassword())
            && $user->getRole() == self::ADMIN_ROLE_USER
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidUser($username, $password)
    {
        $user = $this->userRepository->getUserByUsername($username);

        if (
            !empty($user)
            && $this->verifyPasswordHash($password, $user->getPassword())
            && $user->getRole() == self::NORMAL_ROLE_USER
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function createAdmin(Request $request)
    {
        $user = new ApiUser();
        $user->setUsername($request->query->get('username'))
            ->setPassword($this->encryptPassword($request->query->get('password')))
            ->setRole(self::ADMIN_ROLE_USER);

        $this->userRepository->save($user);

        return $user->toArray();
    }

    public function createUser(Request $request)
    {
        $user = new ApiUser();
        $user->setUsername($request->query->get('username'))
            ->setPassword($this->encryptPassword($request->query->get('password')))
            ->setRole(self::NORMAL_ROLE_USER);

        $this->userRepository->save($user);

        return $user->toArray();
    }

    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function verifyPasswordHash($password, $hash)
    {
        return password_verify($password ,$hash);
    }
}