<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/11/2015
 * Time: 17:59
 */

namespace WellFollowedBundle\Service;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Entity\User;
use OAuth2\ServerBundle\Manager\ClientManager;
use OAuth2\ServerBundle\Manager\ScopeManager;
use OAuth2\ServerBundle\User\OAuth2UserProvider;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\WellFollowedException;
use WellFollowedBundle\Contract\Manager\UserManagerInterface;
use WellFollowedBundle\Contract\Service\UserServiceInterface;

class UserManager implements UserManagerInterface
{
    private $userProvider;
    private $em;
    private $clientManager;
    private $userCredentialsGrantType;
    private $scopeManager;

    public function __construct(OAuth2UserProvider $userProvider, EntityManager $entityManager, ClientManager $clientManager, $userCredentialsGrantType, ScopeManager $scopeManager)
    {
        $this->userProvider = $userProvider;
        $this->em = $entityManager;
        $this->clientManager = $clientManager;
        $this->userCredentialsGrantType = $userCredentialsGrantType;
        $this->scopeManager = $scopeManager;
    }

    public function createUser(User $user)
    {
        $existingUser = $this->em->getRepository('OAuth2ServerBundle:User')
            ->find($user->getUsername());

        if (!is_null($existingUser))
            throw new WellFollowedException(ErrorCode::USER_EXISTS);

        $this->clientManager
            ->createClient(
                $user->getUsername(),
                array('http://localhost:8085'),
                array('password'),
                array('readsensor')
            )
            ;

        return $this->userProvider
            ->createUser($user->getUsername(), $user->getPassword());
    }
}