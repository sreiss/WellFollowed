<?php

namespace WellFollowed\AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use WellFollowed\AppBundle\Entity\Sensor;

/**
 * Class SensorModel
 * @package WellFollowed\AppBundle\Model
 *
 * @Serializer\ExclusionPolicy("all")
 */
class SensorModel
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list","details"})
     */
    private $name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list","details"})
     */
    private $tag;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list","details"})
     */
    private $description;

    /**
     * SensorModel constructor.
     * @param string $id
     * @param string $tag
     * @param string $description
     */
    public function __construct(Sensor $sensor)
    {
        $this->name = $sensor->getName();
        $this->tag = $sensor->getTag();
        $this->description = $sensor->getDescription();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}