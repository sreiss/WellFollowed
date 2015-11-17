<?php

namespace WellFollowedBundle\Contract\Manager;


interface SensorManagerInterface
{
    function getSensorQueue($sensorName);
}