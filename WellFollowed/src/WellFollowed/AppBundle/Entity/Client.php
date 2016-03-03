<?php


namespace WellFollowed\AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as OAuthClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("oauth2_client")
 * @ORM\Entity
 */
class Client extends OAuthClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}