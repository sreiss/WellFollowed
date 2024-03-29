<?php

namespace WellFollowed\AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\BaseController;
use WellFollowed\SecurityBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@WellFollowedApp/default/index.html.twig', array(

        ));
    }
}
