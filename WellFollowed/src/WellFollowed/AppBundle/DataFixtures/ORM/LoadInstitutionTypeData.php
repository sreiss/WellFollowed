<?php


namespace WellFollowed\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellFollowed\AppBundle\Entity\InstitutionType;

class LoadInstitutionTypeData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $institutionTypes1 = new InstitutionType();
        $institutionTypes1->setTag('I.U.T.');

        $institutionTypes2 = new InstitutionType();
        $institutionTypes2->setTag('Université');

        $manager->persist($institutionTypes1);
        $manager->persist($institutionTypes2);

        $manager->flush();
    }
}