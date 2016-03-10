<?php

namespace WellFollowed\AppBundle\Model;

use WellFollowed\AppBundle\Entity\Event;
use WellFollowed\AppBundle\Model\UserModel;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class EventModel
 * @package WellFollowed\AppBundle\Model
 *
 * Represents the events displayed on the calendar.
 *
 * @Serializer\ExclusionPolicy("all")
 */
class EventModel {
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $end;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $description;

    /**
     * @var \WellFollowed\AppBundle\Model\UserModel
     *
     * @Serializer\Type("WellFollowed\AppBundle\Model\UserModel")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $user;

    /**
     * @var boolean
     *
     * @Serializer\Type("boolean")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $cancelled;

    public function __construct(Event $event, UserModel $user = null)
    {
        $this->id = $event->getId();
        $this->title = $event->getTitle();
        $this->start = $event->getStart();
        $this->end = $event->getEnd();
        $this->description = $event->getDescription();
        $this->user = $user;
        $this->cancelled = $event->isCancelled();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return UserModel
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserModel $user
     */
    public function setUser(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * @return boolean
     */
    public function isCancelled()
    {
        return $this->cancelled;
    }

    /**
     * @param boolean $cancelled
     */
    public function setCancelled($cancelled)
    {
        $this->cancelled = $cancelled;
    }
}