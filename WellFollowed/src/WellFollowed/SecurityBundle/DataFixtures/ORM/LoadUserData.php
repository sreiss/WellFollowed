<?php

namespace WellFollowed\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellFollowed\SecurityBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $users = [
            [
                'username' => 'administrator',
                'plainPassword' => 'administrator',
                'email' => 'admin@example.com',
                'firstName' => 'Admin',
                'lastName' => 'Istrator',
                'groups' => ['admins']
            ],
            [
                'username' => 'lambdauser',
                'plainPassword' => 'lambdauser',
                'email' => 'user@example.com',
                'firstName' => 'Lambda',
                'lastName' => 'User',
                'groups' => ['users']
            ]
        ];

        $userManager = $this->container->get('fos_user.user_manager');
        $groupManager = $this->container->get('fos_user.group_manager');

        foreach ($users as $userData) {
            $user = $userManager->createUser();

            $user->setUsername($userData['username']);
            $user->setPlainPassword($userData['plainPassword']);
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            $user->setSubscriptionDate(new \DateTime());
            $user->setEnabled(true);
            foreach($userData['groups'] as $groupName) {
                $group = $groupManager->findGroupBy(['name' => $groupName]);
                $user->addGroup($group);
            }
            $userManager->updateUser($user);
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}