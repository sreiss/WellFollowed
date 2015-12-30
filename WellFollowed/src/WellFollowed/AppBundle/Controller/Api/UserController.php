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
use WellFollowed\UtilBundle\Annotation\FilterContent;

use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\UserManager;

/**
 * Class UserController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Route("/user")
 */
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
     * @JsonContent("WellFollowed\AppBundle\Model\User\UserModel")
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