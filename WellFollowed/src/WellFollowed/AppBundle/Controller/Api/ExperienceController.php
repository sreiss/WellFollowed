<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Manager\ExperienceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\Filter\ExperienceFilter;
use WellFollowed\UtilBundle\Annotation\JsonContent;
use WellFollowed\UtilBundle\Annotation\FilterContent;

/**
 * Class ExperienceController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Route("/experience")
 */
class ExperienceController extends ApiController
{
    private $experienceManager;

    /**
     * @param ExperienceManager $experienceManager
     *
     * @DI\InjectParams({
     *      "experienceManager" = @DI\Inject("well_followed.experience_manager")
     * })
     */
    public function __construct(ExperienceManager $experienceManager)
    {
        $this->experienceManager = $experienceManager;
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route(" ", name="get_experiences")
     * @Method({"GET"})
     * @FilterContent("WellFollowed\AppBundle\Manager\Filter\ExperienceFilter")
     */
    public function getExperiencesAction(Request $request)
    {
        $experiences = $this->experienceManager
            ->getExperiences($request->attributes->get('filter'));

        return $this->jsonResponse($experiences);
    }
}