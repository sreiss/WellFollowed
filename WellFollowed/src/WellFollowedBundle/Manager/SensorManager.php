<?php

namespace WellFollowedBundle\Manager;


use Doctrine\ORM\EntityManager;
use WellFollowedBundle\Contract\Manager\SensorManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Manager\Filter\SensorFilter;

/**
 * Class SensorManager
 * @package WellFollowedBundle\Manager
 *
 * @DI\Service("well_followed.sensor_manager")
 */
class SensorManager implements SensorManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * SensorManager constructor.
     * @param EntityManager $entityManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Obtient la file de messages du capteur dont le nom est passé en paramètre.
     * @param $sensorName
     * @return mixed
     */
    public function getSensorQueue($sensorName)
    {
        $queues = array(
            'sensor1' => array(
                10,
                10,
                10,
                11,
                12
            ),
            'sensor2' => array(
                11,
                11,
                12,
                11,
                11
            )
        );

        return $queues[$sensorName];
    }

    /**
     * Renvoie la liste des capteurs filtrés selon l'option filter.
     * @param $filter
     * @return array
     */
    public function getSensors(SensorFilter $filter)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedBundle:Sensor')
            ->createQueryBuilder('s');

        if (!is_null($filter)) {

        }

        return $qb->getQuery()
            ->getResult();
    }

    public function getSensor($sensorName)
    {
        return $this->entityManager->getRepository('WellFollowedBundle:Sensor')
            ->find($sensorName);
    }
}