<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use WellFollowed\AppBundle\Entity\Experiment;
use WellFollowed\AppBundle\Manager\Filter\UserFilter;
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
     * @var EventManager
     */
    private $eventManager;

    /**
     * ExperienceManager constructor.
     * @param $entityManager
     *
     * @DI\InjectParams({
     *     "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "userManager" = @DI\Inject("well_followed.user_manager"),
     *     "eventManager" = @DI\Inject("well_followed.event_manager")
     * })
     */
    public function __construct(EntityManager $entityManager, UserManager $userManager, EventManager $eventManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->eventManager = $eventManager;
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
        if ($model->getEvent() === null)
            throw new WellFollowedException(ErrorCode::NO_EXPERIMENT_EVENT_SPECIFIED);

        $experiment = new Experiment();

        $experiment->setName($model->getName());
        $experiment->setInitiator($this->userManager->findUserByUsername($model->getInitiator()->getUsername()));

        $event = $this->eventManager->getEventAsEntity($model->getEvent()->getId());
        $experiment->setEvent($event);

        if ($model->getAllowedUsers() !== null) {
            $usernames = array_map(function ($userModel) {
                return $userModel->getUsername();
            }, $model->getAllowedUsers());

            $userFilter = new UserFilter();
            $userFilter->setUsernames($usernames);

            $allowedUsers = $this->userManager->getUsersAsEntity($userFilter);
            $experiment->setAllowedUsers($allowedUsers);
        }

        $this->entityManager->persist($experiment);
        $this->entityManager->flush();

        return new ExperimentModel($experiment);
    }
}