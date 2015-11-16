<?php

namespace UtilBundle\EventListener;

use JMS\Serializer\Serializer;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use UtilBundle\Contract\Controller\JsonControllerInterface;
use UtilBundle\Processor\JsonContentProcessor;

class JsonListener
{
    /**
     * @var JsonContentProcessor
     */
    private $processor;

    /**
     * JsonListener constructor.
     * @param JsonContentProcessor $processor
     */
    public function __construct(JsonContentProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof JsonControllerInterface) {
            $request = $event->getRequest();
            $this->processor->deserializeJsonContent($controller[0], $request);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!empty($event->getRequest()->attributes->get('entity'))) {
            $response = $event->getResponse();
            $this->processor->serializeJsonContent($response);
        }
    }
}