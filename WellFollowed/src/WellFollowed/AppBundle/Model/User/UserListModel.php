<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 30/12/2015
 * Time: 18:07
 */

namespace WellFollowed\AppBundle\Model\User;

use JMS\Serializer\Annotation\SerializedName as Serializer;
use WellFollowed\OAuth2ServerBundle\Entity\User;


class UserListModel
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
    private $username;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $firstName;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $lastName;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
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