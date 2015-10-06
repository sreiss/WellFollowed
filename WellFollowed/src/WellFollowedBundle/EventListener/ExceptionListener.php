<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 23:17
 */

namespace WellFollowedBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener {
    public function onKernelException(GetResponseForExceptionEvent $event) {

    }
}