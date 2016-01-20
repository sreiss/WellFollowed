<?php

namespace WellFollowed\AppBundle\Model\User;

use WellFollowed\OAuth2\ServerBundle\Entity\User;
use JMS\Serializer\Annotation as Serializer;

class UserModel
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $username;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\SerializedName("firstName")
     */
    private $firstName;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\SerializedName("lastName")
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("subscriptionDate")
     */
    private $subscriptionDate;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     */
    private $roles;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     */
    private $scopes;

    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->subscriptionDate = $user->getSubscriptionDate();
        $this->roles = $user->getRoles();
        $this->scopes = $user->getScopes();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTime
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    /**
     * @param \DateTime $subscriptionDate
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }
}