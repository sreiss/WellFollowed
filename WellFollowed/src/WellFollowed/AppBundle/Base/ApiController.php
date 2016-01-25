<?php

namespace WellFollowed\AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends Controller {
    private $modelClass = null;
    private $filterClass = null;
    private $allowedScopes = null;
    private $methodAllowedScopes = [];

    protected function setModelClass($className)
    {
        $this->modelClass = $className;
    }

    protected function setFilterClass($className)
    {
        $this->filterClass = $className;
    }

    public function getAllowedScopes()
    {
        return $this->allowedScopes;
    }

    public function setAllowedScopes(array $scopes)
    {
        $this->allowedScopes = $scopes;
    }

    /**
     * @return array
     */
    public function getMethodAllowedScopes()
    {
        return $this->methodAllowedScopes;
    }

    /**
     * @param array $methodAllowedScopes
     */
    public function setMethodAllowedScopes($methodAllowedScopes)
    {
        $this->methodAllowedScopes = $methodAllowedScopes;
    }

    public function addMethodAllowedScopes($methodName, array $scopes)
    {
        $this->methodAllowedScopes[$methodName] = $scopes;
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