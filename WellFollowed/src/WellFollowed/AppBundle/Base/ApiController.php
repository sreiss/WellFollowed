<?php

namespace WellFollowed\AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller implements TokenControllerInterface {
    private $modelClass = null;
    private $filterClass = null;

    public function setModelClass($className)
    {
        $this->modelClass = $className;
    }

    public function setFilterClass($className)
    {
        $this->filterClass = $className;
    }

    /**
     * @param mixed $data Un tableau associatif représentant l'objet à sérialiser.
     * @return JsonResponse @see JsonResponse
     * @throws \Exception
     */
    public function jsonResponse($data) {
        $response = new Response($this->get('jms_serializer')->serialize($data, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request @see Request
     * @return array Un tableau associatif contenant la version déserialisée du corps de la requête.
     */
    public function jsonRequest(Request $request, $entity) {
        $body = $request->getContent();

        //$object = json_decode($request->getContent());

        $serializer = $this->get('jms_serializer');

        return $serializer->deserialize($body, $entity, 'json');
    }
}