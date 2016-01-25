<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use WellFollowed\AppBundle\Manager\EventManager;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\Filter\EventFilter;
use WellFollowed\UtilBundle\Annotation\JsonContent;
use WellFollowed\UtilBundle\Annotation\FilterContent;

/**
 * Class EventController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Route("/event")
 */
class EventController extends ApiController implements JsonControllerInterface
{
    private $eventManager;

    /**
     * @DI\InjectParams({
     *      "eventManager" = @DI\Inject("well_followed.event_manager")
     * })
     */
    public function __construct(EventManager $eventManager) {
        $this->eventManager = $eventManager;
    }

    /**
     * @Route(" ", name="get_events")
     * @Method({"GET"})
     * @JsonContent("WellFollowed\AppBundle\Entity\Event")
     * @FilterContent("WellFollowed\AppBundle\Manager\Filter\EventFilter")
     */
    public function getEvents(Request $request)
    {
        $events = $this->eventManager
            ->getEvents($request->attributes->get('filter'));

        return $this->jsonResponse($events);
    }

    /**
     * @Route(" ", name="post_event")
     * @Method({"POST"})
     * @JsonContent("WellFollowed\AppBundle\Entity\Event")
     */
    public function createEvent(Request $request)
    {
        $event = $this->eventManager
            ->createEvent($request->attributes->get('json'));

        return $this->jsonResponse($event);
    }

    /**
     * @Route("/{id}", name="delete_event", requirements={"id" = "\d+"}))
     * @Method({"DELETE"})
     */
    public function deleteEvent(Request $request, $id) {
        $this->eventManager
            ->deleteEvent($id);

        return $this->jsonResponse($id);
    }
}