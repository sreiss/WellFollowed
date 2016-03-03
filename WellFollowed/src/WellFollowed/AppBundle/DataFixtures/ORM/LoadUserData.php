<?php


namespace WellFollowed\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellFollowed\AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $user->setUsername('administrator');
        $user->setPlainPassword('administrator');
        $user->setEmail('admin@example.com');
        $user->setFirstName('Admin');
        $user->setLastName('Istrator');
        $user->setSubscriptionDate(new \DateTime());
        $user->setEnabled(true);
        $userManager->updateUser($user);
    }
}