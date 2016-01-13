<?php

namespace WellFollowed\AppBundle\Model\Experience;

use WellFollowed\AppBundle\Entity\Experience;

class ExperienceListModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * ExperienceListModel constructor.
     */
    public function __construct(Experience $experience)
    {
        $this->id = $experience->getId();
        $this->name = $experience->getName();
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
}