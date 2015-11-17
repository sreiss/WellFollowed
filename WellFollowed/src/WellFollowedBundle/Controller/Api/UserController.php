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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowedBundle\Base\ApiController;
use UtilBundle\Annotation\JsonContent;

use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Contract\Manager\UserManagerInterface;

class UserController extends ApiController implements JsonControllerInterface
{
    /** @var  UserManagerInterface */
    private $userManager;

    /**
     * UserController constructor.
     * @param UserManagerInterface $userManager
     *
     * @DI\InjectParams({
     *      @DI\Inject("well_followed.user_manager")
     * })
     */
    public function __construct(UserManagerInterface $userManager)
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
     * @JsonContent("OAuth2\ServerBundle\Entity\User")
     */
    public function createUser(Request $request)
    {
        $user = $this->get('well_followed.user_manager')
            ->createUser($request->attributes->get('json'));

        return new Response($user);
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