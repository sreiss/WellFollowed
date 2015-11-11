<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 00:05
 */

namespace WellFollowedBundle\Base;

use Symfony\Component\HttpKernel\Exception\HttpException;

class WellFollowedException extends HttpException
{
    public function __construct($errorCode, \Exception $previous = null, $statusCode = 500, array $headers = array(), $code = 0)
    {
        parent::__construct($statusCode, $errorCode, $previous, $headers, $code);
    }
}