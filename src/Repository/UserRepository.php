<?php

namespace Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class UserRepository
 *
 * @package Entity
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class UserRepository
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Save a user
     *
     * @param User $user
     * @return User
     * @throws UniqueConstraintViolationException
     */
    public function save(User $user)
    {
        $this->em->beginTransaction();

        try {
            $this->em->persist($user);
            $this->em->flush();
            $this->em->commit();

            return $user;
        } catch (UniqueConstraintViolationException $e) {
            $this->em->rollback();

            throw new UniqueConstraintViolationException;
        }
    }

    /**
     * Remove a user
     *
     * @param User $user
     * @throws \Exception
     */
    public function delete(User $user)
    {
        $this->em->beginTransaction();

        try {
            $this->em->remove($user);
            $this->em->flush();
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();

            throw new \Exception;
        }
    }

    /**
     * Return all users
     *
     * @return array
     */
    public function findAll()
    {
        return $this->em->getRepository("Entity\User")->findAll();
    }

    /**
     * Find an user by id
     *
     * @param $id
     * @return null|object
     */
    public function findOne($id)
    {
        return $this->em->getRepository("Entity\User")->find($id);
    }

    /**
     * Find an user by email
     *
     * @param $email
     * @return array
     */
    public function findEmail($email)
    {
        return $this->em->getRepository("Entity\User")->findBy([
            "email" => $email
        ]);
    }

    /**
     * Search for user with params
     * $search = [
     *      "search" => "search name or email"
     * ]
     *
     * @param array $search
     * @return User[]
     */
    public function search(array $search)
    {
        // Start the query builder
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select("u")->from("Entity\User", "u");

        // Check if the array have the key search and is not empty
        // append to the query
        if (null != $search["search"]) {
            $queryBuilder->where("(LOWER(u.email) LIKE :search) OR (LOWER(u.name) LIKE :search)");
            $queryBuilder->setParameter("search", sprintf("%%%s%%", strtolower($search["search"])));
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Authentication
     *
     * @param User $user
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function auth(User $user)
    {
        // Start the query builder
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select("u")->from("Entity\User", "u")->where("u.email LIKE :email")->setMaxResults(1);

        $queryBuilder->setParameters([
            "email" => $user->getEmail(),
        ]);

        $result = $queryBuilder->getQuery()->getSingleResult();

        return $result;
    }
}