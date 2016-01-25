<?php

namespace WellFollowed\AppBundle\Manager\Filter;

use WellFollowed\AppBundle\Base\ResponseFormat;
use WellFollowed\UtilBundle\Contract\Manager\Filter\FilterInterface;

class UserFilter implements FilterInterface
{
    private $format = ResponseFormat::LIST_FORMAT;

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
}