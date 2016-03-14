<?php

namespace WellFollowed\RecordingBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SensorMessageModel
 * @package WellFollowed\AppBundle\Model
 */
class SensorMessageModel
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("sensorName")
     * @var string
     */
    private $sensorName;

    /**
     * @Serializer\Type("DateTime")
     * @var \DateTime
     */
    private $date;

    /**
     * @Serializer\Type("double")
     * @var float
     */
    private $value;

    /**
     * AMPQSensorMessageModel constructor.
     * @param string $sensorName
     * @param \DateTime $date
     * @param float $value
     */
    public function __construct($sensorName, \DateTime $date, $value)
    {
        $this->sensorName = $sensorName;
        $this->date = $date;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getSensorName()
    {
        return $this->sensorName;
    }

    /**
     * @param string $sensorName
     */
    public function setSensorName($sensorName)
    {
        $this->sensorName = $sensorName;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}