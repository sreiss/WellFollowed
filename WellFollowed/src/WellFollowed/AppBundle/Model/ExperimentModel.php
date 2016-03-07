<?php


namespace WellFollowed\AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use WellFollowed\AppBundle\Entity\Experiment;

/**
 * Class ExperienceModel
 * @package WellFollowed\AppBundle\Model
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ExperimentModel
{
    /**
     * @var integer
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
    private $name;

    /**
     * @var \WellFollowed\AppBundle\Model\UserModel
     *
     * @Serializer\Type("WellFollowed\AppBundle\Model\UserModel")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $initiator;

    /**
     * @var \WellFollowed\AppBundle\Model\EventModel
     *
     * @Serializer\Type("WellFollowed\AppBundle\Model\EventModel")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $event;

    /**
     * @var \WellFollowed\AppBundle\Model\UserModel[]
     *
     * @Serializer\Type("array<WellFollowed\AppBundle\Model\UserModel>")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $allowedUsers;

    /**
     * ExperienceModel constructor.
     */
    public function __construct(Experiment $experiment)
    {
        $this->id = $experiment->getId();
        $this->name = $experiment->getName();
        $this->initiator = new UserModel($experiment->getInitiator());
        $this->event = new EventModel($experiment->getEvent());
        if (!empty($experiment->getAllowedUsers()->getValues())) {
            $this->allowedUsers = array_map(function ($user) {
                return new UserModel($user);
            }, $experiment->getAllowedUsers());
        }
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

    /**
     * @return UserModel
     */
    public function getInitiator()
    {
        return $this->initiator;
    }

    /**
     * @param UserModel $initiator
     */
    public function setInitiator($initiator)
    {
        $this->initiator = $initiator;
    }

    /**
     * @return EventModel
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param EventModel $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return UserModel[]
     */
    public function getAllowedUsers()
    {
        return $this->allowedUsers;
    }

    /**
     * @param UserModel[] $allowedUsers
     */
    public function setAllowedUsers($allowedUsers)
    {
        $this->allowedUsers = $allowedUsers;
    }
}