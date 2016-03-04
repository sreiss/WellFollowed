<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Entity\Experiment;
use WellFollowed\AppBundle\Model\ExperimentModel;

/**
 * Class ExperimentManager
 * @package WellFollowed\AppBundle\Manager
 *
 * @DI\Service("well_followed.experiment_manager")
 */
class ExperimentManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * ExperienceManager constructor.
     * @param $entityManager
     *
     * @DI\InjectParams({
     *     "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "userManager" = @DI\Inject("well_followed.user_manager")
     * })
     */
    public function __construct(EntityManager $entityManager, UserManager $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }

    public function getCurrentExperimentId()
    {
        return 0;
    }


    public function getExperiments(ParamFetcher $filter = null)
    {
        $models = [];
        $qb = null;

        if ($filter !== null)
        {

        }

        if ($qb === null) {
            $qb = $this->entityManager
                ->createQuery('SELECT partial e.{id,name} FROM WellFollowedAppBundle:Experiment e');

            $experiments = $qb->getResult();

            foreach ($experiments as $experiment) {
                $model = new ExperimentModel($experiment);
                $models[] = $model;
            }
        }

        return $models;
    }

    public function createExperiment(ExperimentModel $model)
    {
        $experiment = new Experiment();

        $experiment->setName($model->getName());
        $experiment->setInitiator($model->getInitiator());

        $usernames = array_map(function($userModel) {

        }, $model->getAllowedUsers());

        $experiment->setEvent($model->getEvent());
    }
}