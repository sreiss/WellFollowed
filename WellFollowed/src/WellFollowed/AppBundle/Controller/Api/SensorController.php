<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Manager\SensorManager;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use WellFollowed\UtilBundle\Annotation\FilterContent;
use WellFollowed\UtilBundle\Annotation\AllowedScopes;

/**
 * Class SensorController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Route("/sensor")
 * @AllowedScopes({"access_sensor"})
 */
class SensorController extends ApiController implements JsonControllerInterface
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
     * @Route(" ", name="get_sensors")
     * @Method({"GET"})
     * @FilterContent("WellFollowed\AppBundle\Manager\Filter\SensorFilter")
     */
    public function getSensors(Request $request)
    {
        $sensors = $this->sensorManager
            ->getSensors($request->attributes->get('filter'));

        return $this->jsonResponse($sensors);
    }

    /**
     * @Route("/{name}", name="get_sensor", requirements={"name" = "[a-zA-Z0-9]+"})
     * @Method({"GET"})
     */
    public function getSensor(Request $request, $sensorName)
    {
        return $this->jsonResponse(
            $this->sensorManager
                ->getSensor($sensorName)
        );
    }
}