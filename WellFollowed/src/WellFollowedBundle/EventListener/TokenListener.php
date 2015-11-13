<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/11/2015
 * Time: 16:35
 */

namespace WellFollowedBundle\EventListener;


use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\TokenControllerInterface;
use WellFollowedBundle\Base\WellFollowedException;

class TokenListener
{
    private $tokens = [];

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof TokenControllerInterface) {
            $token = $event->getRequest()->headers->get('Authorization');
            if (!in_array($token, $this->tokens)) {
                //throw new WellFollowedException(ErrorCode::UNAUTHORIZED, null, 401);
            }
        }
    }
}