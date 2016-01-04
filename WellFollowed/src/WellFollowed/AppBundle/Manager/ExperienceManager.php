<?php

namespace WellFollowed\AppBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class ExperienceService
 * @package WellFollowed\AppBundle\Manager
 *
 * @DI\Service("well_followed.experience_manager")
 */
class ExperienceManager
{
    public function getCurrentExperienceId() {
        return 0;
    }
}