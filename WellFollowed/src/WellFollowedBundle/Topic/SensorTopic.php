<?php
namespace WellFollowedBundle\Topic;

use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Contract\Manager\SensorManagerInterface;

/**
 * Class SensorTopic
 * @package WellFollowedBundle\Topic
 *
 * @DI\Service("well_followed.sensor_topic")
 * @DI\Tag("gos_web_socket.topic")
 */
class SensorTopic implements TopicInterface {

    /** @var  SensorManagerInterface */
    private $sensorManager;

    /**
     * SensorTopic constructor.
     * @param SensorManagerInterface $sensorManager
     *
     * @DI\InjectParams({
     *      "sensorManager" = @DI\Inject("well_followed.sensor_manager")
     * })
     */
    public function __construct(SensorManagerInterface $sensorManager)
    {
        $this->sensorManager = $sensorManager;
    }

    /**
     * This will receive any Subscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return void
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        $sensorName = $request->getAttributes()->get('sensorName');
//        $connection->event($topic->getId(), array(
//            'msg' => $this->sensorManager->getSensorQueue($sensorName)
//        ));
    }

    /**
     * This will receive any UnSubscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return voids
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        $connection->event($topic->getId(), array(
            'msg' => ''
        ));
    }


    /**
     * This will receive any Publish requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param $Topic topic
     * @param WampRequest $request
     * @param $event
     * @param array $exclude
     * @param array $eligibles
     * @return mixed|void
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        /*
            $topic->getId() will contain the FULL requested uri, so you can proceed based on that

            if ($topic->getId() == "acme/channel/shout")
               //shout something to all subs.
        */

        $topic->broadcast([
            'msg' => $event
        ]);
    }

    /**
     * Like RPC is will use to prefix the channel
     * @return string
     */
    public function getName()
    {
        return 'wellfollowed.sensor';
    }
}