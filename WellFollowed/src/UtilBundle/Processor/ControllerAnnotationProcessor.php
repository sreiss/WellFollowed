<?php

namespace UtilBundle\Processor;

use JMS\Serializer\Serializer;
use Metadata\MetadataFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ControllerAnnotationProcessor
{
    private $factory;
    private $serializer;

    public function __construct(MetadataFactoryInterface $factory, Serializer $serializer)
    {
        $this->factory = $factory;
        $this->serializer = $serializer;
    }

    public function onKernelController(Controller $controller, Request $request)
    {
        if (!is_object($controller)) {
            throw new \InvalidArgumentException('No controller provided');
        }

        $classMetadata = $this->factory->getMetadataForClass(get_class($controller));

        foreach ($classMetadata->methodMetadata as $methodMetadata) {
            if (isset($methodMetadata->entity)) {
                if (!empty($body = $request->getContent()))
                    $request->attributes->set('json', $this->serializer->deserialize($body, $methodMetadata->entity, 'json'));
                else
                    $request->attributes->set('json', '');
            }

            if (isset($methodMetadata->filterClass)) {
                $filter = new $methodMetadata->filterClass();
                foreach ($request->query as $queryParam => $value) {
                    if (method_exists($filter, ($methodName = 'set' . ucfirst($queryParam)))) {
                        if (preg_match('/[0-9]{4}\-[0-1][0-9]-[0-3][0-9]\T[0-9]{2}\:[0-9]{2}\:[0-9]{2}\.[0-9]{3}[Z]?/', $value)) {
                            $filter->$methodName(new \DateTime($value));
                        } else {
                            $filter->$methodName($value);
                        }
                    }
                }
                $request->attributes->set('filter', $filter);
            }
        }

        return $controller;
    }

    public function onKernelResponse(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        if (!empty($body = $response->getContent()))
            $response->setContent($this->serializer->serialize($body, 'json'));
        else
            $response->setContent('');
    }
}