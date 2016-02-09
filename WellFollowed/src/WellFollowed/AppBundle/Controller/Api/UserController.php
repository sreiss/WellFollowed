<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\UtilBundle\Annotation\JsonContent;
use WellFollowed\UtilBundle\Annotation\FilterContent;
use WellFollowed\UtilBundle\Annotation\AllowedScopes;

use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\UserManager;

/**
 * Class UserController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @AllowedScopes({"access_user"})
 * @Route("/user")
 */
class UserController extends ApiController
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
     * @Route(" ", name="get_users")
     * @Method({"GET"})
     * @FilterContent("WellFollowed\AppBundle\Manager\Filter\UserFilter")
     */
    public function getUsersAction(Request $request)
    {
        $models = $this->userManager
            ->getUsers($request->attributes->get('filter'));

        return $this->jsonResponse($models);
    }

    /**
     * @Route("/{username}", name="get_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     * @Method({"GET"})
     * @AllowedScopes({"access_current_user"})
     */
    public function getUserAction(Request $request, $username)
    {
        $user = $this->userManager
            ->getUser($username);

        return $this->jsonResponse($user);
    }

    /**
     * @Route(" ", name="create_user")
     * @Method({"POST"})
     * @JsonContent("WellFollowed\AppBundle\Model\UserModel")
     * @AllowedScopes({"all"})
     */
    public function createUserAction(Request $request)
    {
        $model = $this->userManager
            ->createUser($request->attributes->get('json'));

        return $this->jsonResponse($model);
        /*
        $user = $this->getDoctrine()
            ->getRepository('WellFollowed\AppBundle:User')
            ->createUser($this->jsonRequest($request, 'WellFollowed\AppBundle\Entity\User'));

        return $this->jsonResponse($user);
        */
    }

    /**
     * @Route("/{username}", name="delete_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     * @Method({"DELETE"})
     */
    public function deleteUser(Request $request, $username)
    {
        $this->userManager
            ->deleteUser($username);

        return $this->jsonResponse(null);
    }

}