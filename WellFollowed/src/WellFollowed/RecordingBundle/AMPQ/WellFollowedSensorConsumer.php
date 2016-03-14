<?php

namespace WellFollowed\RecordingBundle\AMPQ;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\RecordingBundle\Manager\SensorManager;

/**
 * Class WellFollowedSensorConsumer
 * @package WellFollowed\RecordingBundle\AMPQ
 * {@inheritdoc}
 *
 * @DI\Service("well_followed.recording.sensor_consumer")
 */
class WellFollowedSensorConsumer implements ConsumerInterface
{
    private $sensorManager;
    private $serializer;

    /**
     * @DI\InjectParams({
     *     "sensorManager" = @DI\Inject("well_followed.recording.sensor_manager"),
     *     "serializer" = @DI\Inject("jms_serializer")
     * })
     */
    public function __construct(SensorManager $sensorManager, Serializer $serializer)
    {
        $this->sensorManager = $sensorManager;
        $this->serializer = $serializer;
    }

    /**
     * @param AMQPMessage $message The message
     * @return mixed false to reject and requeue, any other value to aknowledge
     */
    public function execute(AMQPMessage $message)
    {
//        try {
            $sensorMessage = $message->body;

            $model = $this->serializer->deserialize($sensorMessage, 'WellFollowed\RecordingBundle\Model\NumericRecordModel', 'json', DeserializationContext::create()->setGroups(['sensor-server']));

            return $this->sensorManager->enqueue($model);
//        } catch (\Exception $e) {
//            echo 'Malformed message discarded: "' . $sensorMessage . '".';
//            return true;
//        }
    }
}