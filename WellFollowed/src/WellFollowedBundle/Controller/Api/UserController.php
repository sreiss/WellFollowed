<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 22:31
 */

namespace WellFollowedBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;

class UserController extends BaseController {
    /**
     * @Route("/api/user", name="get_users")
     * @Method({"GET"})
     */
    public function getUser() {
        $users = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:User')
            ->findUsers();

        return $this->jsonResponse(array(
           'users' => $users
        ));
    }

    /**
     * @Route("/api/user", name="post_user")
     * @Method({"POST"})
     */
    public function addUser(Request $request) {
        $user = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:User')
            ->createUser($this->jsonRequest($request, 'WellFollowedBundle\Entity\User'));

        return $this->jsonResponse($user);
    }

}