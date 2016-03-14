<?php

namespace WellFollowed\RecordingBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use WellFollowed\RecordingBundle\Exception\NotImplementedException;

/**
 * Class RecordModel
 * @package WellFollowed\AppBundle\Model\Recording
 *
 * Represents a message, sent by the sensor.
 * In order to get custom data, you must inherit from this class.
 */
abstract class RecordModel
{
    /**
     * @var double
     * @Serializer\Type("double")
     * @Serializer\Groups({"sensor-server", "server-client"})
     */
    private $id;

    /**
     * @var \DateTime
     * @Serializer\Type("DateTime")
     * @Serializer\Groups({"sensor-server", "server-client"})
     */
    private $date;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\Groups({"sensor-server"})
     * @Serializer\SerializedName("sensorName")
     */
    private $sensorName;

    /**
     * @return float
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return mixed
     */
    public function getSensorName()
    {
        return $this->sensorName;
    }

    /**
     * @param mixed $sensorName
     */
    public function setSensorName($sensorName)
    {
        $this->sensorName = $sensorName;
    }

    /**
     * @param string
     */
    public function getRecordModel($type)
    {
        switch ($type) {
            case 'numeric':
                return new NumericRecordModel();
            default:
                throw new NotImplementedException('The type ' . $type . ' was not implemented.');
        }
    }
}