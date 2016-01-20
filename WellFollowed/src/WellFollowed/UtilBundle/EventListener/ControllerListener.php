<?php

namespace WellFollowed\UtilBundle\EventListener;

use JMS\Serializer\Serializer;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\UtilBundle\Processor\ControllerAnnotationProcessor;

class ControllerListener
{
    /**
     * @var ControllerAnnotationProcessor
     */
    private $processor;

    /**
     * JsonListener constructor.
     * @param ControllerAnnotationProcessor $processor
     */
    public function __construct(ControllerAnnotationProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiController) {
            $request = $event->getRequest();
            $this->processor->onKernelController($controller[0], $request);
        }
    }

//    public function onKernelResponse(FilterResponseEvent $event)
//    {
//        if (!empty($event->getRequest()->attributes->get('entity'))) {
//            $response = $event->getResponse();
//            $this->processor->onKernelResponse($response);
//        }
//    }
}