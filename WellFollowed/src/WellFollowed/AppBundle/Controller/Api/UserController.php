<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\UserManager;
use WellFollowed\AppBundle\Model\UserModel;

/**
 * Class UserController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/user")
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
     * @Rest\Get(" ")
     * @Rest\View(serializerGroups={"list"})
     */
    public function getUsersAction(Request $request)
    {
        $models = $this->userManager
            ->getUsers();

        return $models;
        //return $this->jsonResponse($models);
    }

    /**
     * @Rest\Get("/{username}", name="get_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     */
    public function getUserAction(Request $request, $username)
    {
        $user = $this->userManager
            ->getUser($username);

        return $user;
    }

    /**
     * @Rest\Post(" ", name="create_user")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"update", "details"}}})
     */
    public function createUserAction(UserModel $model)
    {
        return $this->userManager
            ->createUser($model);
    }

    /**
     * @Rest\Delete("/{username}", name="delete_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     */
    public function deleteUser(Request $request, $username)
    {
        return $this->userManager
            ->deleteUser($username);
    }

}