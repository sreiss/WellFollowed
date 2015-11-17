<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 26/10/15
 * Time: 22:00
 */

namespace WellFollowedBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowedBundle\Base\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Contract\Manager\EventManagerInterface;
use WellFollowedBundle\Manager\Filter\EventFilter;
use UtilBundle\Annotation\JsonContent;
use UtilBundle\Annotation\FilterContent;


class EventController extends ApiController implements JsonControllerInterface
{
    private $eventManager;

    /**
     * @DI\InjectParams({
     *      "eventManager" = @DI\Inject("well_followed.event_manager")
     * })
     */
    public function __construct(EventManagerInterface $eventManager) {
        $this->eventManager = $eventManager;
    }

    /**
     * @Route("/event", name="get_events")
     * @Method({"GET"})
     * @JsonContent("WellFollowedBundle\Entity\Event")
     * @FilterContent("WellFollowedBundle\Manager\Filter\EventFilter")
     */
    public function getEvents(Request $request)
    {
//        $filter = new EventFilter();
//        if (!is_null($start = $request->query->get('start')))
//            $filter->setStart(new \DateTime($start));
//        if (!is_null($end = $request->query->get('end')))
//            $filter->setEnd(new \DateTime($end));
//        $filter->setFormat($request->query->get('format'));

        $events = $this->eventManager
            ->getEvents($request->attributes->get('filter'));

        return $this->jsonResponse($events);
    }

    /**
     * @Route("/event", name="post_event")
     * @Method({"POST"})
     * @JsonContent("WellFollowedBundle\Entity\Event")
     */
    public function createEvent(Request $request)
    {
        $event = $this->eventManager
            ->createEvent($request->attributes->get('json'));

        return $this->jsonResponse($event);
    }

    /**
     * @Route("/event/{id}", name="delete_event", requirements={"id" = "\d+"}))
     * @Method({"DELETE"})
     */
    public function deleteEvent(Request $request, $id) {
        $this->eventManager
            ->deleteEvent($id);

        return $this->jsonResponse($id);
    }
}