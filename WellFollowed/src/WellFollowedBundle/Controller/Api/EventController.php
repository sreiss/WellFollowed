<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 26/10/15
 * Time: 22:00
 */

namespace WellFollowedBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class EventController extends BaseController
{
    /**
     * @Route("/api/event", name="get_events")
     * @Method({"GET"})
     */
    public function getEvents(Request $request)
    {
        $filter = [];
        if (!is_null($start = $request->query->get('start')))
            $filter['start'] = new \DateTime($start);
        if (!is_null($end = $request->query->get('end')))
            $filter['end'] = new \DateTime($end);

        $events = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:Event')
            ->findEvents($filter);

        return $this->jsonResponse($events);
    }

    /**
     * @Route("/api/event", name="post_event")
     * @Method({"POST"})
     */
    public function createEvent(Request $request)
    {
        $event = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:Event')
            ->createEvent($this->jsonRequest($request, 'WellFollowedBundle\Entity\Event'));

        return $this->jsonResponse($event);
    }

}