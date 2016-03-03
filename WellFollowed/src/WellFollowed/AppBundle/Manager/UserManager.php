<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Acl\Exception\Exception;
use WellFollowed\AppBundle\Base\ResponseFormat;
use WellFollowed\AppBundle\Manager\Filter\UserFilter;
use WellFollowed\AppBundle\Model\UserModel;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class UserManager
 * @package WellFollowed\AppBundle\Service
 * @DI\Service("well_followed.user_manager")
 */
class UserManager
{
    private $userManager;
    private $entityManager;

    /**
     * @param UserManagerInterface $userManager
     * @param EntityManager $entityManager
     *
     * @DI\InjectParams({
     *      "userManager" = @DI\Inject("fos_user.user_manager"),
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(UserManagerInterface $userManager, EntityManager $entityManager)
    {
        $this->userManager = $userManager;
        $this->entityManager = $entityManager;
    }

    public function getUsers(UserFilter $filter = null)
    {
        $models = [];
        $qb = null;

        if ($filter !== null) {
            // TODO: handle filter
        }

        $users = $this->userManager->findUsers();

        foreach ($users as $user) {
            $model = new UserModel($user);
            $models[] = $model;
        }

        return $models;
    }

    public function getUser($username)
    {
        $user = $this->userManager
            ->findUserByUsername($username);

        if ($user === null)
            throw new WellFollowedException(ErrorCode::NOT_FOUND);

        return new UserModel($user);
    }

    public function createUser(UserModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        $user = $this->userManager->createUser();
        $user->setEmail($model->getEmail());
        $user->setUsername($model->getUsername());
        $user->setPlainPassword($model->getPassword());
        $user->setLastName($model->getLastName());
        $user->setFirstName($model->getFirstName());
        $user->setSubscriptionDate(new \DateTime());
        $user->setEnabled(true);
        $this->userManager->updateUser($user);

        return new UserModel($user);
    }

    public function deleteUser($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if ($user === null) {
            throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
        }

        $this->userManager->deleteUser($username);

        return true;
    }
}