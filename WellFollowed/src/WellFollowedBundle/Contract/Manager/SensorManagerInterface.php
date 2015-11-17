<?php

namespace WellFollowedBundle\Contract\Manager;


use WellFollowedBundle\Manager\Filter\SensorFilter;

interface SensorManagerInterface
{
    function getSensorQueue($sensorName);
    function getSensor($sensorName);
    function getSensors(SensorFilter $filter);
}