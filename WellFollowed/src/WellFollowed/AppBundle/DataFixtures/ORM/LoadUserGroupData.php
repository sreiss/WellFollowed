<?php


namespace WellFollowed\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserGroupData implements FixtureInterface, ContainerAwareInterface
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
                'name' => 'Administrateurs',
                'roles' => [
                    'READ_EVENT',
                    'READ_EXPERIMENT',
                    'READ_INSTITUTION',
                    'READ_USER',
                    'CONTROL_EVENT',
                    'CONTROL_EXPERIMENT',
                    'CONTROL_INSTITUTION',
                    'CONTROL_USER'
                ]
            ],
            [
                'name' => 'Utilisateurs',
                'roles' => [
                    'READ_EVENT',
                    'READ_EXPERIMENT'
                ]
            ]
        ];
        $groupManager = $this->container->get('fos_user.group_manager');

        foreach($groups as $groupData) {
            $group = $groupManager->createGroup($groupData['name']);
            $group->setRoles($groupData['roles']);
            $groupManager->updateGroup($group);
        }
    }
}