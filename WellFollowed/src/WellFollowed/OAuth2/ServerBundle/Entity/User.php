<?php

namespace WellFollowed\OAuth2\ServerBundle\Entity;

use OAuth2\ServerBundle\User\OAuth2UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User implements OAuth2UserInterface
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="username", type="string", length=130)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=130)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=130)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscription_date", type="datetime")
     */
    private $subscriptionDate;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="simple_array", nullable=true)
     */
    private $roles;

    /**
     * @var array
     *
     * @ORM\Column(name="scopes", type="simple_array", nullable=true)
     */
    private $scopes;

    /**
     * @var \WellFollowed\AppBundle\Entity\Experience[]
     *
     * @ORM\ManyToMany(targetEntity="\WellFollowed\AppBundle\Entity\Experience", mappedBy="allowed_users")
     */
    private $experiences;

    /**
     * Set username
     *
     * @param  string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param  string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param  string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param  array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set scopes
     *
     * @param  array $scopes
     * @return User
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return implode(' ', $this->getScopes());
    }

    /**
     * Erase credentials
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // We don't hold anything sensitivie, do nothing
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
     * @return \WellFollowed\AppBundle\Entity\Experience[]
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * @param \WellFollowed\AppBundle\Entity\Experience[] $experiences
     */
    public function setExperiences($experiences)
    {
        $this->experiences = $experiences;
    }
}
