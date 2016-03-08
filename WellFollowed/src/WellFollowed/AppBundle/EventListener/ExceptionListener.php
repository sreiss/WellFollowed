<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 23:17
 */

namespace WellFollowed\AppBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;

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

        $data = array(
            'message' => $exception->getMessage()
        );

        if ($this->environment == 'dev') {
            $data['trace'] = $exception->getTraceAsString();
        }

        $response = new Response($this->jmsSerializer->serialize($data,'json'));

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}