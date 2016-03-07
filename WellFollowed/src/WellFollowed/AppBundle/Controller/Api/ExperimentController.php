<?php

namespace WellFollowed\AppBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use WellFollowed\AppBundle\Manager\ExperimentManager;
use WellFollowed\AppBundle\Model\ExperimentModel;

/**
 * Class ExperienceController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/experiment")
 */
class ExperimentController extends ApiController
{
    /**
     * @var ExperimentManager
     */
    private $experimentManager;

    /**
     * @param ExperimentManager $experimentManager
     * @internal param ExperimentManager $experienceManager
     *
     * @DI\InjectParams({
     *      "experimentManager" = @DI\Inject("well_followed.experiment_manager")
     * })
     */
    public function __construct(ExperimentManager $experimentManager)
    {
        $this->experimentManager = $experimentManager;
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Rest\Get(" ", name="get_experiments")
     * @Rest\View(serializerGroups={"list"})
     */
    public function getExperimentsAction(ParamFetcher $filter)
    {
        return $this->experimentManager
            ->getExperiments($filter);
    }

    /**
     * @param ExperimentModel $model
     *
     * @Rest\Post(" ", name="create_experiment")
     * @Rest\View(serializerGroups={"details"})
     * @ParamConverter("model")
     */
    public function createExperimentAction(ExperimentModel $model)
    {
        return $this->experimentManager
            ->createExperiment($model);
    }
}