<?php

namespace WellFollowedBundle\Manager\Filter;


use UtilBundle\Contract\Manager\Filter\FilterInterface;
use WellFollowedBundle\Base\Filter\ResponseFormat;

class InstitutionTypeFilter implements FilterInterface
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