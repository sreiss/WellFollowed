<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 22:31
 */

namespace WellFollowed\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\UtilBundle\Annotation\JsonContent;

use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\UserManager;

class UserController extends ApiController implements JsonControllerInterface
{
    /** @var  UserManager */
    private $userManager;

    /**
     * UserController constructor.
     * @param UserManager $userManager
     *
     * @DI\InjectParams({
     *      "userManager" = @DI\Inject("well_followed.user_manager")
     * })
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/user", name="get_all_users")
     * @Method({"GET"})
     */
    public function getAllUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository('WellFollowed\AppBundle:User')
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
        $user = $this->userManager
            ->getUser($id);

        return $this->jsonResponse($user);
    }

    /**
     * @Route("/user", name="post_user")
     * @Method({"POST"})
     * @JsonContent("OAuth2\ServerBundle\Entity\User")
     */
    public function createUser(Request $request)
    {
        $user = $this->get('well_followed.user_manager')
            ->createUser($request->attributes->get('json'));

        return $this->jsonResponse($user);
        /*
        $user = $this->getDoctrine()
            ->getRepository('WellFollowed\AppBundle:User')
            ->createUser($this->jsonRequest($request, 'WellFollowed\AppBundle\Entity\User'));

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
            ->getRepository('WellFollowedAppBundle:User')
            ->deleteUser($id);

        return $this->jsonResponse($id);
    }

}