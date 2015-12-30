<?php

namespace WellFollowed\UtilBundle\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Metadata\MergeableClassMetadata;
use Doctrine\Common\Annotations\Reader;
use WellFollowed\UtilBundle\Metadata\JsonContentMetadata;

class ControllerAnnotationDriver implements DriverInterface
{
    private $annotationClasses;

    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
        $this->annotationClasses = array(
            'WellFollowed\UtilBundle\\Annotation\\JsonContent' => array('entity'),
            'WellFollowed\UtilBundle\\Annotation\\FilterContent' => array('filterClass')
        );
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new MergeableClassMetadata($class->getName());

        if (!preg_match('/Controller\\\(.+)Controller$/', $class->name))
            return $classMetadata;

        foreach ($class->getMethods() as $reflectionMethod) {
            $methodMetadata = new JsonContentMetadata($class->getName(), $reflectionMethod->getName());

            foreach ($this->annotationClasses as $annotationClass => $attributes) {
                $annotation = $this->reader->getMethodAnnotation(
                    $reflectionMethod,
                    $annotationClass
                );


                if (!is_null($annotation)) {
                    foreach ($attributes as $attribute) {
                        $methodName = 'get' . ucfirst($attribute);
                        $methodMetadata->$attribute = $annotation->$methodName();
                        $classMetadata->addMethodMetadata($methodMetadata);
                    }
                }
            }
        }

        return $classMetadata;
    }
}