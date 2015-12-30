<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Exception\ScopeNotFoundException;
use OAuth2\ServerBundle\Manager\ScopeManagerInterface;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class ClientManager
 * @package WellFollowed\AppBundle\Manager
 * @DI\Service("well_followed.client_manager")
 */
class ClientManager
{
    private $em;

    /**
     * @var ScopeManagerInterface
     */
    private $sm;
    private $clientManager;

    /**
     * @param EntityManager $entityManager
     * @param ScopeManagerInterface $scopeManager
     * @param \OAuth2\ServerBundle\Manager\ClientManager $clientManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "scopeManager" = @DI\Inject("oauth2.scope_manager"),
     *      "clientManager" = @DI\Inject("oauth2.client_manager")
     * })
     */
    public function __construct(EntityManager $entityManager, ScopeManagerInterface $scopeManager, \OAuth2\ServerBundle\Manager\ClientManager $clientManager)
    {
        $this->em = $entityManager;
        $this->sm = $scopeManager;
        $this->clientManager = $clientManager;
    }

    /**
     * Creates a new client
     *
     * @param string $identifier
     *
     * @param array $redirect_uris
     *
     * @param array $grant_type
     *
     * @param array $scopes
     *
     * @return Client
     */
    public function createClient($identifier, array $redirect_uris = array(), array $grant_types = array(), array $scopes = array(), $isPublic = false)
    {
        if (!$isPublic)
            return $this->clientManager->createClient($identifier, $redirect_uris, $grant_types, $scopes);


        $clientExists = false;
        $client = $this->findClient($identifier);
        if ($client) {
            $clientExists = true;
        } else {
            $client = new \OAuth2\ServerBundle\Entity\Client();
        }
        $client->setClientId($identifier);
        $client->setClientSecret('');
        $client->setRedirectUri($redirect_uris);
        $client->setGrantTypes($grant_types);

        // Verify scopes
        foreach ($scopes as $scope) {
            // Get Scope
            $scopeObject = $this->sm->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }

        $client->setScopes($scopes);

        // Store Client
        if (!$clientExists)
            $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    public function findClient($id) {
        return $this->em->getRepository('OAuth2ServerBundle:Client')->find($id);
    }
}
