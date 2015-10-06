<?php

namespace WellFollowedBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller {
    /**
     * @param array $data Un tableau associatif représentant l'objet à sérialiser.
     * @return JsonResponse @see JsonResponse
     * @throws \Exception
     */
    public function jsonResponse($data) {
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    /**
     * @param Request $request @see Request
     * @return array Un tableau associatif contenant la version déserialisée du corps de la requête.
     */
    public function jsonRequest(Request $request) {
        return json_decode($request->getContent());
    }
}