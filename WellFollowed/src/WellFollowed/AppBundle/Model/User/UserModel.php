<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 12/11/2015
 * Time: 23:07
 */

namespace WellFollowed\AppBundle\Model\User;

use WellFollowed\AppBundle\Entity\User;

class UserModel
{
    private $id;
    private $login;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->login = $user->getLogin();
    }
}