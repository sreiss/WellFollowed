<?php

namespace WellFollowed\RecordingBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class NumericRecordModel extends RecordModel
{
    /**
     * @var double
     * @Serializer\Type("double")
     * @Serializer\Groups({"sensor-server", "server-client"})
     */
    private $value;

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}