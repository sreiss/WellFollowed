<?php

namespace UtilBundle\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Metadata\MergeableClassMetadata;
use Doctrine\Common\Annotations\Reader;
use UtilBundle\Metadata\JsonContentMetadata;

class ControllerAnnotationDriver implements DriverInterface
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new MergeableClassMetadata($class->getName());

        if (!preg_match('/Controller\\\(.+)Controller$/', $class->name))
            return $classMetadata;

        foreach ($class->getMethods() as $reflectionMethod) {
            $methodMetadata = new JsonContentMetadata($class->getName(), $reflectionMethod->getName());

            $annotation = $this->reader->getMethodAnnotation(
                $reflectionMethod,
                'UtilBundle\\Annotation\\JsonContent'
            );

            if (!is_null($annotation)) {
                $methodMetadata->entity = $annotation->getEntity();
                $classMetadata->addMethodMetadata($methodMetadata);
            }
        }

        return $classMetadata;
    }
}