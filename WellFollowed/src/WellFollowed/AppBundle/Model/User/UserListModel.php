<?php

namespace WellFollowed\AppBundle\Model\User;

use JMS\Serializer\Annotation as Serializer;
use WellFollowed\OAuth2\ServerBundle\Entity\User;

class UserListModel
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $username;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("firstName")
     */
    private $firstName;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("lastName")
     */
    private $lastName;

    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}