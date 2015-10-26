<?php

namespace WellFollowedBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;
use WellFollowedBundle\Entity\User;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@WellFollowed/default/index.html.twig', array(

        ));
    }
}
