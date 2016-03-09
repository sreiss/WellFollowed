<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Manager\SensorManager;
use WellFollowed\AppBundle\Base\ApiController;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class SensorController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/sensor")
 */
class SensorController extends ApiController
{
    /**
     * @var SensorManager
     */
    private $sensorManager;

    /**
     * SensorController constructor.
     * @param SensorManager $sensorManager
     *
     * @DI\InjectParams({
     *      "sensorManager" = @DI\Inject("well_followed.sensor_manager")
     * })
     */
    public function __construct(SensorManager $sensorManager)
    {
        $this->sensorManager = $sensorManager;
    }

    /**
     * @Rest\Get(" ", name="get_sensors")
     * @Rest\View(serializerGroups={"details"})
     * @Security("has_role('READ_EXPERIMENT')")
     */
    public function getSensorsAction(Request $request)
    {
        return $this->sensorManager
            ->getSensors();
    }

    /**
     * @Rest\Get("/{name}", name="get_sensor", requirements={"name" = "[a-zA-Z0-9]+"})
     * @Security("has_role('READ_EXPERIMENT')")
     */
    public function getSensorAction(Request $request, $sensorName)
    {
        return $this->sensorManager
                ->getSensor($sensorName);
    }
}