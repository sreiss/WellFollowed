<?php

namespace WellFollowed\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellFollowed\SecurityBundle\Entity\UserGroup;

class LoadUserGroupData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
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
        $groups = [
            [
                'name' => 'admins',
                'tag' => 'Administrateurs',
                'roles' => [
                    'READ_ADMIN',
                    'READ_EVENT',
                    'READ_EXPERIMENT',
                    'READ_INSTITUTION',
                    'READ_USER',
                    'CREATE_EVENT',
                    'CREATE_EXPERIMENT',
                    'CREATE_INSTITUTION',
                    'CREATE_USER',
                    'UPDATE_EVENT',
                    'UPDATE_EXPERIMENT',
                    'UPDATE_INSTITUTION',
                    'UPDATE_USER',
                    'DELETE_EVENT',
                    'DELETE_EXPERIMENT',
                    'DELETE_INSTITUTION',
                    'DELETE_USER'
                ]
            ],
            [
                'name' => 'users',
                'tag' => 'Utilisateurs',
                'roles' => [
                    'READ_EXPERIMENT'
                ]
            ]
        ];
        //$groupManager = $this->container->get('fos_user.group_manager');

        foreach($groups as $groupData) {
            $group = new UserGroup($groupData['name']);
            $group->setRoles($groupData['roles']);
            $group->setTag($groupData['tag']);
            $manager->persist($group);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}