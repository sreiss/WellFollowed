<?php

namespace WellFollowed\UtilBundle\Annotation;

/**
 * Class FilterContent
 * @package WellFollowed\UtilBundle\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
final class FilterContent
{
    /** @var string */
    private $filterClass;

    /**
     * FilterContent constructor.
     * @param $filterClass
     */
    public function __construct(array $options)
    {
        if (isset($options['value'])) {
            $options['filterClass'] = $options['value'];
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
     * @return string
     */
    public function getFilterClass()
    {
        return $this->filterClass;
    }

    /**
     * @param string $filterClass
     */
    public function setFilterClass($filterClass)
    {
        $this->filterClass = $filterClass;
    }
}