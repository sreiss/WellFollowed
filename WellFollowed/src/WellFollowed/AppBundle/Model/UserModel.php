<?php

namespace WellFollowed\AppBundle\Model;

use WellFollowed\AppBundle\Entity\User;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class UserModel
 * @package WellFollowed\AppBundle\Model
 *
 * @Serializer\ExclusionPolicy("all")
 */
class UserModel
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $username;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $email;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"update"})
     */
    private $password;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\SerializedName("firstName")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\SerializedName("lastName")
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("subscriptionDate")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $subscriptionDate;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Expose
     * @Serializer\Groups({"details"})
     */
    private $roles;

    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->roles = $user->getRoles();
        $this->subscriptionDate = $user->getSubscriptionDate();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
}