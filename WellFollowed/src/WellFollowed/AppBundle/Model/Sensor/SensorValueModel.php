<?php

namespace WellFollowed\AppBundle\Model\Sensor;

use JMS\Serializer\Annotation as Serializer;

class SensorValueModel
{
    /**
     * @var \DateTime
     * @Serializer\Type("DateTime")
     */
    private $date;

    /**
     * @var double
     * @Serializer\Type("double")
     */
    private $value;

    /**
     * SensorValue constructor.
     * @param \DateTime $date
     * @param double $value
     */
    public function __construct($date, $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}