<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 01/10/15
 * Time: 22:31
 */

namespace WellFollowedBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use WellFollowedBundle\Base\BaseController;

class UserController extends BaseController {
    /**
     * @Route("api/user", name="get_user")
     * @Method({"GET"})
     */
    public function getUser() {
        return $this->jsonResponse(array(
           'ok' => 'ok'
        ));
    }

    /**
     * @Route("api/user", name="post_user")
     * @Method({"POST"})
     */
    public function addUser(Request $request) {
        $body = $this->jsonRequest($request);
        return $this->jsonResponse($body);
    }

}