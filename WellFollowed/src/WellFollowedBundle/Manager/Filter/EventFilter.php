<?php

namespace WellFollowedBundle\Manager\Filter;

use UtilBundle\Contract\Manager\Filter\FilterInterface;
use WellFollowedBundle\Base\Filter\ResponseFormat;

/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 13/11/2015
 * Time: 00:54
 */
class EventFilter implements FilterInterface
{
    private $start;
    private $end;
    private $format;

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }

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