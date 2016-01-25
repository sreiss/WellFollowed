<?php

namespace WellFollowed\AppBundle\Manager\Filter;

use WellFollowed\UtilBundle\Contract\Manager\Filter\FilterInterface;
use WellFollowed\AppBundle\Base\ResponseFormat;

class EventFilter implements FilterInterface
{
    private $start;
    private $end;
    private $format = ResponseFormat::FULL_FORMAT;

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