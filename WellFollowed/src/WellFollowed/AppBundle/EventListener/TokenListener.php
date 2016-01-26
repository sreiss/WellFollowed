<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/11/2015
 * Time: 16:35
 */

namespace WellFollowed\AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use OAuth2\HttpFoundationBridge\Request;
use OAuth2\HttpFoundationBridge\Response;
use OAuth2\Server;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\TokenControllerInterface;
use WellFollowed\AppBundle\Base\WellFollowedException;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TokenListener
 * @package WellFollowed\AppBundle\EventListener
 *
 * @DI\Service("well_followed.tokens.action_listener")
 * @DI\Tag("kernel.event_listener", attributes = { "event" = "kernel.controller", "method" = "onKernelController" })
 */
class TokenListener
{
    private $entityManager = null;
    private $oauth2Server = null;

    /**
     * @param EntityManager $entityManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "oauth2Server" = @DI\Inject("oauth2.server")
     * })
     */
    public function __construct(EntityManager $entityManager, Server $oauth2Server)
    {
        $this->entityManager = $entityManager;
        $this->oauth2Server = $oauth2Server;
    }

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

        if ($controller[0] instanceof ApiController)
        {
            $methodAllowedScopes = $controller[0]->getMethodAllowedScopes();
            if (isset($methodAllowedScopes) && isset($methodAllowedScopes[$controller[1]])) {
                $scopes = empty($methodAllowedScopes[$controller[1]]) ? null : implode(' ', $methodAllowedScopes[$controller[1]]);
            } else {
                $scopes = empty($controller[0]->getAllowedScopes()) ? null : implode(' ', $controller[0]->getAllowedScopes());
            }

            if ($scopes !== 'all') {
             //   $result = $this->oauth2Server->verifyResourceRequest($controller[0]->get('oauth2.request'), $controller[0]->get('oauth2.response'), $scopes);

            //    if (!$result) {
            //        throw new WellFollowedException(ErrorCode::UNAUTHORIZED, null, 401);
            //    }
            }
        }
    }
}