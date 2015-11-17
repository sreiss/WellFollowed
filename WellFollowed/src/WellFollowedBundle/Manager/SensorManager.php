<?php

namespace WellFollowedBundle\Manager;


use WellFollowedBundle\Contract\Manager\SensorManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class SensorManager
 * @package WellFollowedBundle\Manager
 *
 * @DI\Service("well_followed.sensor_manager")
 */
class SensorManager implements SensorManagerInterface
{
    public function getSensorQueue($sensorName)
    {
        $queues = array(
            'sensor1' => array(10,10,10,11,12),
            'sensor2' => array(11,11,12,11,11)
        );

        return $queues[$sensorName];
    }
}