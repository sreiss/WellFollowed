<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\Filter\ExperienceFilter;
use WellFollowed\AppBundle\Model\Experience\ExperienceListModel;

/**
 * Class ExperienceService
 * @package WellFollowed\AppBundle\Manager
 *
 * @DI\Service("well_followed.experience_manager")
 */
class ExperienceManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ExperienceManager constructor.
     * @param $entityManager
     *
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCurrentExperienceId()
    {
        return 0;
    }


    public function getExperiences(ExperienceFilter $filter = null)
    {
        $models = [];
        $qb = null;

        if ($filter !== null)
        {

        }

        if ($qb === null) {
            $qb = $this->entityManager
                ->createQuery('SELECT partial e.{id,name} FROM WellFollowedAppBundle:Experience e');

            $experiences = $qb->getResult();

            foreach ($experiences as $experience) {
                $model = new ExperienceListModel($experience);
                $models[] = $model;
            }
        }

        return $models;
    }
}