<?php

namespace WellFollowed\AppBundle\AMPQ;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\SensorManager;

/**
 * Class WellFollowedSensorConsumer
 * @package WellFollowed\AppBundle\AMPQ
 *
 * @DI\Service("well_followed.sensor_consumer")
 */
class WellFollowedSensorConsumer implements ConsumerInterface
{
    private $sensorManager;

    /**
     * @DI\InjectParams({
     *     "sensorManager" = @DI\Inject("well_followed.sensor_manager")
     * })
     */
    public function __construct(SensorManager $sensorManager)
    {
        $this->sensorManager = $sensorManager;
    }

    /**
     * @param AMQPMessage $message The message
     * @return mixed false to reject and requeue, any other value to aknowledge
     */
    public function execute(AMQPMessage $message)
    {
        $sensorMessage = $message->body;

        return $this->sensorManager->enqueue($sensorMessage['name'], $sensorMessage['date'], $sensorMessage['value']);
    }
}