<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/11/2015
 * Time: 17:59
 */

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use WellFollowed\AppBundle\Base\Filter\ResponseFormat;
use WellFollowed\AppBundle\Manager\Filter\UserFilter;
use WellFollowed\AppBundle\Model\User\UserListModel;
use WellFollowed\AppBundle\Model\User\UserModel;
use WellFollowed\OAuth2ServerBundle\Entity\User;
use OAuth2\ServerBundle\Manager\ScopeManager;
use WellFollowed\OAuth2ServerBundle\Manager\ClientManager;
use WellFollowed\OAuth2ServerBundle\User\OAuth2UserProvider;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use WellFollowed\AppBundle\Contract\Manager\UserManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class UserManager
 * @package WellFollowed\AppBundle\Service
 * @DI\Service("well_followed.user_manager")
 */
class UserManager implements UserManagerInterface
{
    private $userProvider;
    private $entityManager;
    private $clientManager;
    private $userCredentialsGrantType;
    private $scopeManager;

    /**
     * @param OAuth2UserProvider $userProvider
     * @param EntityManager $entityManager
     * @param ClientManager $clientManager
     * @param $userCredentialsGrantType
     * @param ScopeManager $scopeManager
     *
     * @DI\InjectParams({
     *      "userProvider" = @DI\Inject("oauth2.user_provider"),
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "clientManager" = @DI\Inject("oauth2.client_manager"),
     *      "userCredentialsGrantType" = @DI\Inject("oauth2.grant_type.user_credentials"),
     *      "scopeManager" = @DI\Inject("oauth2.scope_manager")
     * })
     */
    public function __construct(OAuth2UserProvider $userProvider, EntityManager $entityManager, ClientManager $clientManager, $userCredentialsGrantType, ScopeManager $scopeManager)
    {
        $this->userProvider = $userProvider;
        $this->entityManager = $entityManager;
        $this->clientManager = $clientManager;
        $this->userCredentialsGrantType = $userCredentialsGrantType;
        $this->scopeManager = $scopeManager;
    }

    public function getUsers(UserFilter $filter)
    {
        $models = [];
        $qb = null;

        if (!is_null($filter)) {
            // TODO: handle filter
        }

        if ($qb === null) {
            $qb = $this->entityManager
                ->createQuery('SELECT partial u.{username,lastName,firstName} FROM WellFollowedOAuth2ServerBundle:User u');

            $users = $qb->getResult();

            foreach ($users as $user) {
                $model = new UserListModel($user);
                $models[] = $model;
            }
        }

        return $models;
    }

    public function getUser($username)
    {
        $user = $this->userProvider
            ->loadUserByUsername($username);

        if ($user === null)
            throw new WellFollowedException(ErrorCode::NOT_FOUND);

        return new UserModel($user);
    }

    public function createUser(UserModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        $existingUser = $this->entityManager
            ->getRepository('WellFollowedOAuth2ServerBundle:User')
            ->findOneBy(array('username' => $model->getUsername()));

        if ($existingUser !== null)
            throw new WellFollowedException(ErrorCode::USER_EXISTS);

        $this->clientManager
            ->createClient(
                $model->getUsername(),
                array('http://localhost:8085'),
                array('password'),
                array('readsensor')
            );

        $user = $this->userProvider
            ->createUser(
                $model->getUsername(),
                $model->getPassword(),
                $model->getFirstName(),
                $model->getLastName(),
                $model->getSubscriptionDate(),
                ($model->getRoles() !== null) ?:array(),
                ($model->getScopes() !== null) ?:array()
            );

        return new UserModel($user);
    }

    public function deleteUser($username)
    {
        if ($username !== null) {
            $qb = $this->entityManager
                ->getRepository('WellFollowedOAuth2ServerBundle:User')
                ->createQueryBuilder('u');

            $qb->delete('WellFollowed\OAuth2ServerBundle\Entity\User', 'u')
                ->where('u.username = :username')
                ->setParameter('username', $username);

            $deletedCount = $qb->getQuery()
                ->execute();

            if ($deletedCount == 0)
                throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);

            return $deletedCount;
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}