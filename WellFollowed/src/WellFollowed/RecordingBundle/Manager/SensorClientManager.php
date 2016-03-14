<?php

namespace WellFollowed\RecordingBundle\Manager;

use Doctrine\Common\Cache\ApcCache;
use Gos\Component\WebSocketClient\Wamp\Client;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;

/**
 * Class SensorClientManager
 * @package WellFollowed\RecordingBundle\Manager
 *
 * @DI\Service("well_followed.recording.sensor_client_manager")
 */
class SensorClientManager
{
    private $clientCacheKey = 'wellFollowedSensorClient';
    private $sessionIdCacheKey = 'wellFollowedSensorSessionId';
    private $client = null;
    private $sessionId = null;

    /**
     * SensorClientManager constructor.
     *
     * @DI\InjectParams({
     *      "webSocketPort" = @DI\Inject("%gos_web_socket_port%"),
     *      "webSocketHost" = @DI\Inject("%gos_web_socket_host%")
     * })
     */
    public function __construct($webSocketPort, $webSocketHost)
    {
        //$this->cache->delete($this->clientCacheKey);
        //$this->cache->delete($this->sessionIdCacheKey);
//        if ($client = $this->cache->fetch($this->clientCacheKey) && $sessionId = $this->cache->fetch($this->sessionIdCacheKey)) {
//            $this->client = $client;
//            $this->sessionId = $sessionId;
//        } else {
            $this->client = new Client($webSocketHost, $webSocketPort);
            $this->sessionId = $this->client->connect();
            //$this->cache->save($this->clientCacheKey, $this->client, null);
//            $this->cache->save($this->sessionIdCacheKey, $this->sessionId, null);
//        }
    }

    public function publish($topic, $payload)
    {
        if ($this->client === null)
            throw new WellFollowedException(ErrorCode::NO_CLIENT);

        $this->client->publish($topic, $payload);
    }

    public function disconnect()
    {
        if ($this->client === null)
            throw new WellFollowedException(ErrorCode::NO_CLIENT);

        $this->client->disconnect();

        $this->cache->delete($this->clientCacheKey);
        $this->cache->delete($this->sessionIdCacheKey);

        $this->client = null;
        $this->sessionId = null;
    }
}