<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 04/01/2016
 * Time: 22:24
 */

namespace WellFollowed\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SensorValue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SensorValue
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
     * @var \WellFollowed\AppBundle\Entity\Sensor
     *
     * @ORM\OneToOne(targetEntity="WellFollowed\AppBundle\Entity\Sensor", cascade={"persist"})
     * @ORM\JoinColumn(name="sensor_name", referencedColumnName="name")
     */
    private $sensor;

    /**
     * @var int
     * @ORM\Column(name="experience_id", type="integer")
     */
    private $experienceId;

    /**
     * @var \WellFollowed\AppBundle\Entity\Experience
     *
     * @ORM\OneToOne(targetEntity="WellFollowed\AppBundle\Entity\Experience", cascade={"persist"})
     * @ORM\JoinColumn(name="experience_id", referencedColumnName="id")
     */
    private $experience;

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
     * @return Experience
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param Experience $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
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
     * @return int
     */
    public function getExperienceId()
    {
        return $this->experienceId;
    }

    /**
     * @param int $experienceId
     */
    public function setExperienceId($experienceId)
    {
        $this->experienceId = $experienceId;
    }
}