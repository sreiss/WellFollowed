<?php

namespace WellFollowed\AppBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SensioLabs\Security\SecurityChecker;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\Filter\UserFilter;
use WellFollowed\SecurityBundle\Manager\UserManager;
use WellFollowed\SecurityBundle\Model\UserModel;

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
     * @Rest\QueryParam(array=true, name="usernames", requirements="[a-zA-Z0-9]+", strict=true, default=null, nullable=true)
     * @Security("has_role('READ_USER')")
     */
    public function getUsersAction(ParamFetcher $fetcher)
    {
        $filter = new UserFilter();
        $filter->setUsernames($fetcher->get('usernames'));

        $models = $this->userManager
            ->getUsers($filter);

        return $models;
    }

    /**
     * @Rest\Get("/{username}", name="get_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     */
    public function getUserAction($username)
    {
        if ($this->get('security.authorization_checker')->isGranted('READ_USER')) {
            $model = $this->userManager
                ->getUser($username);
        } else {
            $user = $this->getUser();
            $model = $this->userManager->getModelAsEntity($user);
        }

        return $model;
    }

    /**
     * @Rest\Post(" ", name="create_user")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"update", "details"}}})
     */
    public function createUserAction(UserModel $model)
    {
        return $this->userManager
            ->createWfUser($model);
    }

    /**
     * @Rest\Delete("/{username}", name="delete_user", requirements={"username" = "[a-zA-Z][a-zA-Z0-9]+"})
     * @Security("has_role('DELETE_USER')")
     */
    public function deleteUser(Request $request, $username)
    {
        $this->userManager
            ->deleteUser($username);
        return true;
    }

}