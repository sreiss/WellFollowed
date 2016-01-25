<?php

namespace WellFollowed\AppBundle\Manager\Filter;

use WellFollowed\AppBundle\Base\ResponseFormat;
use WellFollowed\UtilBundle\Contract\Manager\Filter\FilterInterface;

class ExperienceFilter implements FilterInterface
{
    /*
     * @var string Le format dans lequel est renvoyé la réponse.
     */
    private $format = ResponseFormat::LIST_FORMAT;

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
}