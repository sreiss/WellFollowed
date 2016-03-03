<?php


namespace WellFollowed\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Entity\Client;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadClientData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();

        $client->setRandomId('5lftjmdqny0wwo0ccscw8wkkg4wcgc8c4gk0wcsockg0owwgww');
        $client->setRedirectUris(['http://localhost:8085']);
        $client->setSecret('ya2a335wnlwkwkk4gws0wcc80s0gg84o8go0wgooo8ksg88sc');
        $client->setAllowedGrantTypes(['password']);

        $clientManager->updateClient($client);
    }
}