<?php

namespace WellFollowed\AppBundle\Contract\Manager;


use WellFollowed\AppBundle\Manager\Filter\SensorFilter;

interface SensorManagerInterface
{
    function getSensorQueue($sensorName);
    function getSensor($sensorName);
    function getSensors(SensorFilter $filter);
}