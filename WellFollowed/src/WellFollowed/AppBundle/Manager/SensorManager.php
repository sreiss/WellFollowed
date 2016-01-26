<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Entity\SensorValue;
use WellFollowed\AppBundle\Manager\Filter\SensorFilter;
use WellFollowed\AppBundle\Model\AMPQSensorMessageModel;
use WellFollowed\AppBundle\Topic\SensorTopic;

/**
 * Class SensorManager
 * @package WellFollowed\AppBundle\Manager
 *
 * @DI\Service("well_followed.sensor_manager")
 */
class SensorManager
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;

    private $experienceManager = null;

    private $sensorQueues = [];

    private $sensorClientManager = null;

    private $sensorTopic = null;

    /**
     * SensorManager constructor.
     * @param EntityManager $entityManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "experienceManager" = @DI\Inject("well_followed.experience_manager"),
     *      "sensorClientManager" = @DI\Inject("well_followed.sensor_client_manager"),
     *      "sensorTopic" = @DI\Inject("well_followed.sensor_topic")
     * })
     */
    public function __construct(EntityManager $entityManager, ExperienceManager $experienceManager, SensorClientManager $sensorClientManager, SensorTopic $sensorTopic)
    {
        $this->entityManager = $entityManager;
        $this->experienceManager = $experienceManager;
        $this->sensorClientManager = $sensorClientManager;
        $this->sensorTopic = $sensorTopic;
    }

    public function enqueue(AMPQSensorMessageModel $model)
    {
        if (!isset($this->sensorQueues[$model->getSensorName()]))
            $this->sensorQueues[$model->getSensorName()] = [];

        $value = new SensorValue();
        $value->setDate($model->getDate());
        $value->setValue($value);
        $value->setSensorName($model->getSensorName());
        $value->setExperienceId($this->experienceManager->getCurrentExperienceId());
        $this->createSensorValue($value);

        $this->sensorClientManager->publish('sensor/data/sensor1', [
            'date' => $model->getDate(),
            'value' => $model->getValue()
        ]);

        return true;
    }

    private function createSensorValue(SensorValue $value)
    {
        $this->entityManager->persist($value);
    }

    public function flushSensorValues()
    {
        $this->entityManager->flush();
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
            ->getRepository('WellFollowedAppBundle:Sensor')
            ->createQueryBuilder('s');

        if (!is_null($filter)) {

        }

        return $qb->getQuery()
            ->getResult();
    }

    public function getSensor($sensorName)
    {
        return $this->entityManager->getRepository('WellFollowedAppBundle:Sensor')
            ->find($sensorName);
    }
}