<?php

namespace Facade;

use Configurations\SecurityTrait;
use Doctrine\ORM\EntityManager;
use Entity\User;
use Repository\UserRepository;

/**
 * Class UserFacade
 *
 * @package Facade
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class UserFacade
{
    use SecurityTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->userRepository = new UserRepository($em);
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function save(User $user)
    {
        return $this->userRepository->save($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user)
    {
        $this->userRepository->delete($user);
    }

    /**
     * Find all users
     *
     * @return User[]
     */
    public function find()
    {
        return $this->userRepository->findAll();
    }

    /**
     * Find one user
     *
     * @param $id
     * @return User
     */
    public function findOne($id)
    {
        return $this->userRepository->findOne($id);
    }

    /**
     * @param $email
     * @return null|object
     */
    public function findByEmail($email)
    {
        return $this->userRepository->findEmail($email);
    }

    /**
     * @param array $data
     * @return \Entity\User[]
     */
    public function search(array $data)
    {
        return $this->userRepository->search($data);
    }

    /**
     * Authentication
     *
     * @param string $password
     * @param User $user
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return User
     */
    public function auth($password, User $user)
    {
        $user = $this->userRepository->auth($user);

        if ($user instanceof User) {
            if ($this->compare($password, $user->getPassword())) {
                return $user;
            }
        }
    }
}