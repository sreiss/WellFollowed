<?php

namespace WellFollowed\SecurityBundle\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode as OAuthAuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("auth_code")
 * @ORM\Entity
 */
class AuthCode extends OAuthAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;
}