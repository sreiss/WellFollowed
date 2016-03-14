<?php

namespace WellFollowed\RecordingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecordingValue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RecordingValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", nullable=false)
     */
    private $value;

    /**
     * @var string
     * @ORM\Column(name="sensor_name", type="string", length=30, nullable=false)
     */
    private $sensorName;

    /**
     * @var \WellFollowed\RecordingBundle\Entity\Sensor
     *
     * @ORM\OneToOne(targetEntity="WellFollowed\RecordingBundle\Entity\Sensor", cascade={"persist"})
     * @ORM\JoinColumn(name="sensor_name", referencedColumnName="name")
     */
    private $sensor;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return Sensor
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * @param Sensor $sensor
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;
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
}