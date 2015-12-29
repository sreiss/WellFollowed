<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/11/2015
 * Time: 17:59
 */

namespace WellFollowedBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Entity\User;
use OAuth2\ServerBundle\Manager\ScopeManager;
use OAuth2\ServerBundle\User\OAuth2UserProvider;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\WellFollowedException;
use WellFollowedBundle\Contract\Manager\UserManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class UserManager
 * @package WellFollowedBundle\Service
 * @DI\Service("well_followed.user_manager")
 */
class UserManager implements UserManagerInterface
{
    private $userProvider;
    private $em;
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
     *      "clientManager" = @DI\Inject("well_followed.client_manager"),
     *      "userCredentialsGrantType" = @DI\Inject("oauth2.grant_type.user_credentials"),
     *      "scopeManager" = @DI\Inject("oauth2.scope_manager")
     * })
     */
    public function __construct(OAuth2UserProvider $userProvider, EntityManager $entityManager, ClientManager $clientManager, $userCredentialsGrantType, ScopeManager $scopeManager)
    {
        $this->userProvider = $userProvider;
        $this->em = $entityManager;
        $this->clientManager = $clientManager;
        $this->userCredentialsGrantType = $userCredentialsGrantType;
        $this->scopeManager = $scopeManager;
    }

    public function getUser($id)
    {
        return $this->em->getRepository('OAuth2ServerBundle:User')
            ->find($id);
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