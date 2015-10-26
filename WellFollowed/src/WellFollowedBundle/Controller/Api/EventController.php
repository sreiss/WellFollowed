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

class EventController extends BaseController
{
    /**
     * @Route("/api/event", name="get_events")
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
}