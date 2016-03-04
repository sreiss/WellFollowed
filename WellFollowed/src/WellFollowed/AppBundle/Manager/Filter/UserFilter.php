<?php

namespace WellFollowed\AppBundle\Manager\Filter;

use WellFollowed\AppBundle\Base\ResponseFormat;

class UserFilter
{
    private $format = ResponseFormat::LIST_FORMAT;

    /**
     * @var string[]
     */
    private $usernames;

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return \string[]
     */
    public function getUsernames()
    {
        return $this->usernames;
    }

    /**
     * @param \string[] $usernames
     */
    public function setUsernames($usernames)
    {
        $this->usernames = $usernames;
    }
}