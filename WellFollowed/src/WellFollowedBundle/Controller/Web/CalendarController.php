<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 26/10/15
 * Time: 22:28
 */

namespace WellFollowedBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;

class CalendarController extends BaseController {
    /**
     * @Route("/calendrier", name="calendar")
     */
    public function indexAction(Request $request) {
        return $this->render('@WellFollowed/calendar/index.html.twig', array(

        ));
    }
}