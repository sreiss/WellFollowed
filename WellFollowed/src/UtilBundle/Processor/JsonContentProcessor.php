<?php

namespace UtilBundle\Processor;

use JMS\Serializer\Serializer;
use Metadata\MetadataFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JsonContentProcessor
{
    private $factory;
    private $serializer;

    public function __construct(MetadataFactoryInterface $factory, Serializer $serializer)
    {
        $this->factory = $factory;
        $this->serializer = $serializer;
    }

    public function deserializeJsonContent(Controller $controller, Request $request)
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
        }

        return $controller;
    }

    public function serializeJsonContent(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        if (!empty($body = $response->getContent()))
            $response->setContent($this->serializer->serialize($body, 'json'));
        else
            $response->setContent('');
    }
}