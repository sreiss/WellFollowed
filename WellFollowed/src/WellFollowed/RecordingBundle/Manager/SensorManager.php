<?php

namespace WellFollowed\RecordingBundle\Manager;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\ExperimentManager;
use WellFollowed\AppBundle\Manager\Filter\SensorFilter;
use WellFollowed\RecordingBundle\Entity\RecordingValue;
use WellFollowed\RecordingBundle\Model\RecordModel;
use WellFollowed\RecordingBundle\Model\SensorModel;
use WellFollowed\RecordingBundle\Topic\SensorTopic;

/**
 * Class SensorManager
 * @package WellFollowed\RecordingBundle\Manager
 *
 * @DI\Service("well_followed.recording.sensor_manager")
 */
class SensorManager
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;

    private $experimentManager = null;

    private $sensorQueues = [];

    private $sensorClientManager = null;

    private $sensorTopic = null;

    /**
     * SensorManager constructor.
     * @param EntityManager $entityManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "experimentManager" = @DI\Inject("well_followed.experiment_manager"),
     *      "sensorClientManager" = @DI\Inject("well_followed.recording.sensor_client_manager"),
     *      "sensorTopic" = @DI\Inject("well_followed.recording.sensor_topic")
     * })
     */
    public function __construct(EntityManager $entityManager, ExperimentManager $experimentManager, SensorClientManager $sensorClientManager, SensorTopic $sensorTopic)
    {
        $this->entityManager = $entityManager;
        $this->experimentManager = $experimentManager;
        $this->sensorClientManager = $sensorClientManager;
        $this->sensorTopic = $sensorTopic;
    }

    public function enqueue(RecordModel $model)
    {
        if (!isset($this->sensorQueues[$model->getSensorName()]))
            $this->sensorQueues[$model->getSensorName()] = [];

        $value = new RecordingValue();
        $value->setDate($model->getDate());
        $value->setValue($model->getValue());
        $value->setSensorName($model->getSensorName());
        $this->createSensorValue($value);

        echo $model === null;

        print_r($model);

        $this->sensorClientManager->publish('sensor/data/' . $model->getSensorName(), [
            'date' => $model->getDate(),
            'value' => $model->getValue()
        ]);

        return true;
    }

    private function createSensorValue(RecordingValue $value)
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
    public function getSensors(SensorFilter $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedRecordingBundle:Sensor')
            ->createQueryBuilder('s');

        if (!is_null($filter)) {

        }

        $sensors = $qb->getQuery()
            ->getResult();

        $models = [];

        foreach($sensors as $sensor) {
            $models[] = new SensorModel($sensor);
        }

        return $models;
    }

    public function getSensor($sensorName)
    {
        $sensor = $this->entityManager->getRepository('WellFollowedRecordingBundle:Sensor')
            ->find($sensorName);

        return new SensorModel($sensor);
    }
}