<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 23:17
 */

namespace WellFollowedBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\WellFollowedException;

class ExceptionListener
{
    private $jmsSerializer;
    private $environment;

    /**
     * ExceptionListener constructor.
     * @param $jmsSerializer
     * @param $environment
     */
    public function __construct($jmsSerializer, $environment)
    {
        $this->jmsSerializer = $jmsSerializer;
        $this->environment = $environment;
    }


    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $statusCode = 500;
        if ($exception instanceof WellFollowedException) {
            $statusCode = $exception->getStatusCode();
        } else {
            $exception = new WellFollowedException(ErrorCode::UNKNOWN_ERROR, $exception);
        }

        $data = array(
            'message' => $exception->getMessage()
        );

        if ($this->environment == 'dev') {
            $data['trace'] = $exception->getTraceAsString();
        }

        $response = new Response($this->jmsSerializer->serialize($data,'json'));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);

        $event->setResponse($response);
    }
}