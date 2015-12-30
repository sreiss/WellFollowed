<?php
/**
 * Un grand merci à Matthias Noback pour son tutoriel "Symfony2 & Doctrine Common: creating powerful annotations".
 * @link http://php-and-symfony.matthiasnoback.nl/2011/12/symfony2-doctrine-common-creating-powerful-annotations/
 */

/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 14/11/2015
 * Time: 11:50
 */

namespace WellFollowed\UtilBundle\Annotation;

/**
 * Class JsonContent
 * @package WellFollowed\AppBundle\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
final class JsonContent
{
    /** @var object */
    private $entity;

    public function __construct(array $options)
    {
        if (isset($options['value'])) {
            $options['entity'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param object $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}