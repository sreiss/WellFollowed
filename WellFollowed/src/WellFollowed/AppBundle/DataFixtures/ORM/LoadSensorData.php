<?php


namespace WellFollowed\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellFollowed\AppBundle\Entity\Sensor;

class LoadSensorData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $sensor = new Sensor();

        $sensor->setName('sensor1');
        $sensor->setTag('Capteur 1');
        $sensor->setDescription('Capteur supérieur.');

        $manager->persist($sensor);
        $manager->flush();
    }
}