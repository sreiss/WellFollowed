<?php

namespace WellFollowed\UtilBundle\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Metadata\MergeableClassMetadata;
use Doctrine\Common\Annotations\Reader;
use Metadata\MethodMetadata;
use Metadata\PropertyMetadata;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use WellFollowed\UtilBundle\Metadata\JsonContentMetadata;

class ControllerAnnotationDriver implements DriverInterface
{
    private $annotationClasses;

    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
        $this->classAnnotationClasses = array(
            'WellFollowed\UtilBundle\\Annotation\\AllowedScopes' => array('allowedScopes')
        );
        $this->methodAnnotationClasses = array(
            'WellFollowed\UtilBundle\\Annotation\\AllowedScopes' => array('allowedScopes'),
            'WellFollowed\UtilBundle\\Annotation\\JsonContent' => array('entity'),
            'WellFollowed\UtilBundle\\Annotation\\FilterContent' => array('filterClass')
        );
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new MergeableClassMetadata($class->getName());

        if (!preg_match('/Controller\\\(.+)Controller$/', $class->name))
            return $classMetadata;

        foreach ($this->classAnnotationClasses as $annotationClass => $attributes) {
            $annotation = $this->reader->getClassAnnotation(
                $class,
                $annotationClass
            );

            if ($annotation != null) {
                foreach ($attributes as $attribute) {
                    $propertyMetadata = new PropertyMetadata($annotationClass, $attribute);
                    $methodName = 'get' . ucfirst($attribute);
                    $propertyMetadata->$attribute = $annotation->$methodName();
                    $classMetadata->addPropertyMetadata($propertyMetadata);
                }
            }
        }


        foreach ($class->getMethods() as $reflectionMethod) {
            $methodMetadata = new MethodMetadata($class->getName(), $reflectionMethod->getName());

            foreach ($this->methodAnnotationClasses as $annotationClass => $attributes) {
                $annotation = $this->reader->getMethodAnnotation(
                    $reflectionMethod,
                    $annotationClass
                );


                if ($annotation !== null) {
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