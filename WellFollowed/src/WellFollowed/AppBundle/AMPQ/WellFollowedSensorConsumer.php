<?php

namespace WellFollowed\AppBundle\AMPQ;

use JMS\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Config\Definition\Exception\Exception;
use WellFollowed\AppBundle\Manager\SensorManager;

/**
 * Class WellFollowedSensorConsumer
 * @package WellFollowed\AppBundle\AMPQ
 * {@inheritdoc}
 *
 * @DI\Service("well_followed.sensor_consumer")
 */
class WellFollowedSensorConsumer implements ConsumerInterface
{
    private $sensorManager;
    private $serializer;

    /**
     * @DI\InjectParams({
     *     "sensorManager" = @DI\Inject("well_followed.sensor_manager"),
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

            $model = $this->serializer->deserialize($sensorMessage, 'WellFollowed\AppBundle\Model\AMPQSensorMessageModel', 'json');

            return $this->sensorManager->enqueue($model);
//        } catch (\Exception $e) {
//            echo 'Malformed message discarded: "' . $sensorMessage . '".';
//            return true;
//        }
    }
}