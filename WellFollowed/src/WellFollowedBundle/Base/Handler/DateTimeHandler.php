<?php

namespace WellFollowedBundle\Base\Handler;
use JMS\Serializer\Context;
use JMS\Serializer\JsonSerializationVisitor;

/**
 * Utilisé par le bundle JMS\Serialization pour régler le problème de passage de date du json au php.
 */
class DateTimeHandler
{
    public function deserializeDateTimeFromJson(JsonSerializationVisitor $visitor, \DateTime $date, array $type, Context $context)
    {
        return $date->format($type['params'][0]);
    }
}