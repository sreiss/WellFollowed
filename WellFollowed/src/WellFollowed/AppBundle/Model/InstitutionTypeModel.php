<?php

namespace WellFollowed\AppBundle\Model;

use WellFollowed\AppBundle\Entity\InstitutionType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class InstitutionTypeModel
 * @package WellFollowed\AppBundle\Model\InstitutionType
 *
 * @Serializer\AccessType("public_method")
 */
class InstitutionTypeModel
{
    /**
     * @var int
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $tag;

    /**
     * InstitutionTypeModel constructor.
     */
    public function __construct(InstitutionType $institutionType)
    {
        $this->id = $institutionType->getId();
        $this->tag = $institutionType->getTag();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
}