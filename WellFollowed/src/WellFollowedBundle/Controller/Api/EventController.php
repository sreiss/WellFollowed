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
        $events = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:Event')
            ->findEvents();

        return $this->jsonResponse(array(
            'events' => $events
        ));
    }

    /**
     * @Route("/api/event", name="post_event")
     * @Method({"POST"})
     */
    public function createEvent(Request $request)
    {
        $event = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:Event')
            ->createEvent($this->jsonRequest($request));

        return $this->jsonResponse(array(
            'events' => $event
        ));
    }

}