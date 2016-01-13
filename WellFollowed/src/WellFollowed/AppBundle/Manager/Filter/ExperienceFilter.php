<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/01/2016
 * Time: 15:25
 */

namespace WellFollowed\AppBundle\Manager\Filter;


use WellFollowed\AppBundle\Base\Filter\ResponseFormat;

class ExperienceFilter
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