<?php

namespace WellFollowed\OAuth2\ServerBundle\Storage;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Manager\ScopeManagerInterface;
use OAuth2\ServerBundle\Storage\Scope as BaseScope;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class Scope
 * @package WellFollowed\OAuth2ServerBundle\Storage
 *
 * @DI\Service("oauth2.storage.scope")
 */
class Scope extends BaseScope
{
    private $oauth2Clients;

    /**
     * @param EntityManager $entityManager
     * @param ScopeManagerInterface $scopeManager
     * @param $oauth2Clients
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "scopeManager" = @DI\Inject("oauth2.scope_manager"),
     *      "oauth2Clients" = @DI\Inject("%oauth2_clients%")
     * })
     */
    public function __construct(EntityManager $entityManager, ScopeManagerInterface $scopeManager, $oauth2Clients)
    {
        parent::__construct($entityManager, $scopeManager);
        $this->oauth2Clients = $oauth2Clients;
    }

    public function getDefaultScope($client_id = null)
    {
        if (isset($this->oauth2Clients[$client_id]) && isset($this->oauth2Clients[$client_id]['default_scopes'])) {
            return implode(",", $this->oauth2Clients[$client_id]['default_scopes']);
        }
        return false;
    }
}