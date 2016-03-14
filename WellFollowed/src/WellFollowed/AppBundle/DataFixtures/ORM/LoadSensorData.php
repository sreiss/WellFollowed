<?php


namespace WellFollowed\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellFollowed\RecordingBundle\Entity\Sensor;

class LoadSensorData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $sensors = [
            [
                'name' => 'sensor1',
                'tag' => 'Capteur supérieur',
                'description' => 'Capteur supérieur.'
            ],
            [
                'name' => 'sensor2',
                'tag' => 'Capteur central',
                'description' => 'Capteur central'
            ],
            [
                'name' => 'sensor3',
                'tag' => 'Capteur inférieur',
                'description' => 'Capteur inférieur'
            ]
        ];

        foreach ($sensors as $sensorData) {
            $sensor = new Sensor();

            $sensor->setName($sensorData['name']);
            $sensor->setTag($sensorData['tag']);
            $sensor->setDescription($sensorData['description']);

            $manager->persist($sensor);
        }

        $manager->flush();
    }
}