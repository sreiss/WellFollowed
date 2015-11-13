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
use WellFollowedBundle\Base\ApiController;

class UserController extends ApiController
{
    /**
     * @Route("/user", name="get_all_users")
     * @Method({"GET"})
     */
    public function getAllUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:User')
            ->findUsers();

        return $this->jsonResponse(array(
           'users' => $users
        ));
    }

    /**
     * @Route("/user/{id}", name="get_user", requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getAppUser(Request $request, $id)
    {
        return $this->jsonResponse(
            $this->getDoctrine()
                ->getRepository('WellFollowedBundle:User')
                ->find($id)
        );
    }

    /**
     * @Route("/user", name="post_user")
     * @Method({"POST"})
     */
    public function createUser(Request $request)
    {
        $user = $this->get('well_followed.user_manager')
            ->createUser($this->jsonRequest($request, 'OAuth2\ServerBundle\Entity\User'));

        return $user;
        /*
        $user = $this->getDoctrine()
            ->getRepository('WellFollowedBundle:User')
            ->createUser($this->jsonRequest($request, 'WellFollowedBundle\Entity\User'));

        return $this->jsonResponse($user);
        */
    }

    /**
     * @Route("/user/delete/{id}", name="delete_user", requirements={"id" = "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteUser(Request $request, $id)
    {
        $this->getDoctrine()
            ->getRepository('WellFollowedBundle:User')
            ->deleteUser($id);

        return $this->jsonResponse($id);
    }

}