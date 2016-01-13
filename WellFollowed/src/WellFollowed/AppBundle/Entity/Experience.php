<?php

namespace WellFollowed\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sensor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Experience
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \WellFollowed\OAuth2ServerBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="WellFollowed\OAuth2ServerBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="initiator_username", referencedColumnName="username")
     */
    private $initiator;

    /**
     * @var \WellFollowed\AppBundle\Entity\Event
     *
     * @ORM\OneToOne(targetEntity="WellFollowed\AppBundle\Entity\Event", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var \WellFollowed\OAuth2ServerBundle\Entity\User[]
     *
     * @ORM\ManyToMany(targetEntity="WellFollowed\OAuth2ServerBundle\Entity\User", inversedBy="experiences", cascade={"persist"})
     * @ORM\JoinTable(name="experice_allowed_users",
     *      joinColumns={@ORM\JoinColumn(name="experience_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="username", referencedColumnName="username")}
     *      )
     */
    private $allowedUsers;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return \WellFollowed\OAuth2ServerBundle\Entity\User
     */
    public function getInitiator()
    {
        return $this->initiator;
    }

    /**
     * @param \WellFollowed\OAuth2ServerBundle\Entity\User $initiator
     */
    public function setInitiator($initiator)
    {
        $this->initiator = $initiator;
    }

    /**
     * @return \WellFollowed\OAuth2ServerBundle\Entity\User[]
     */
    public function getAllowedUsers()
    {
        return $this->allowedUsers;
    }

    /**
     * @param \WellFollowed\OAuth2ServerBundle\Entity\User[] $allowedUsers
     */
    public function setAllowedUsers($allowedUsers)
    {
        $this->allowedUsers = $allowedUsers;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }
}