<?php

namespace WellFollowed\AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use WellFollowed\AppBundle\Entity\Institution;

/**
 * Class InstitutionModel
 * @package WellFollowed\AppBundle\Model
 *
 * @Serializer\ExclusionPolicy("all")
 */
class InstitutionModel
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $tag;

    /**
     * @Serializer\Type("WellFollowed\AppBundle\Model\InstitutionTypeModel")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $type;

    /**
     * InstitutionModel constructor.
     */
    public function __construct(Institution $institution)
    {
        $this->id = $institution->getId();
        $this->tag = $institution->getTag();
        $this->type = new InstitutionTypeModel($institution->getType());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}