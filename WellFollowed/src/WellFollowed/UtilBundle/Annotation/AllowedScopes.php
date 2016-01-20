<?php
/**
 * Un grand merci à Matthias Noback pour son tutoriel "Symfony2 & Doctrine Common: creating powerful annotations".
 * @link http://php-and-symfony.matthiasnoback.nl/2011/12/symfony2-doctrine-common-creating-powerful-annotations/
 */

namespace WellFollowed\UtilBundle\Annotation;

/**
 * Class Scopes
 * @package WellFollowed\AppBundle\Annotation
 *
 * @Annotation
 * @Target({"METHOD", "CLASS"})
 */
final class AllowedScopes
{
    /** @var array */
    private $allowedScopes;

    public function __construct(array $options)
    {
        if (isset($options['value'])) {
            $options['allowedScopes'] = $options['value'];
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
     * @return array
     */
    public function getAllowedScopes()
    {
        return $this->allowedScopes;
    }

    /**
     * @param array $allowedScopes
     */
    public function setAllowedScopes($allowedScopes)
    {
        $this->allowedScopes = $allowedScopes;
    }
}