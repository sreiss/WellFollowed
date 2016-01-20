<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Contract\Manager\SensorManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use WellFollowed\UtilBundle\Annotation\FilterContent;
use WellFollowed\UtilBundle\Annotation\AllowedScopes;

/**
 * Class SensorController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @AllowedScopes({"access_sensor"})
 */
class SensorController extends ApiController implements JsonControllerInterface
{
    /**
     * @var SensorManagerInterface
     */
    private $sensorManager;

    /**
     * SensorController constructor.
     * @param SensorManagerInterface $sensorManager
     *
     * @DI\InjectParams({
     *      "sensorManager" = @DI\Inject("well_followed.sensor_manager")
     * })
     */
    public function __construct(SensorManagerInterface $sensorManager)
    {
        $this->sensorManager = $sensorManager;
    }

    /**
     * @Route("/sensor", name="get_sensors")
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
     * @Route("/sensor/{name}", name="get_sensor", requirements={"name" = "[a-zA-Z0-9]+"})
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