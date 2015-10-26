<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 20/10/15
 * Time: 16:19
 */

namespace WellFollowedBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;
use WellFollowedBundle\Entity\User;

class AccountController extends BaseController {
    /**
     * @Route("/compte", name="account")
     */
    public function indexAction(Request $request)
    {
        $userForm = $this->createForm('user_form', new User(), array(
            'action' => $this->generateUrl('post_user'),
            'method' => 'POST'
        ));

        // replace this example code with whatever you need
        return $this->render('@WellFollowed/account/index.html.twig', array(
            'userForm' => $userForm->createView()
        ));
    }
}