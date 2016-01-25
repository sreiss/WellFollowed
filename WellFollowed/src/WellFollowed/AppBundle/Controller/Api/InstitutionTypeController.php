<?php

namespace WellFollowed\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use WellFollowed\UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Entity\InstitutionType;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Manager\InstitutionTypeManager;
use WellFollowed\UtilBundle\Annotation\FilterContent;
use WellFollowed\UtilBundle\Annotation\JsonContent;

/**
 * Class InstitutionTypeController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Route("/institution-type")
 */
class InstitutionTypeController extends ApiController implements JsonControllerInterface
{
    private $institutionTypeManager;

    /**
     * @DI\InjectParams({
     *      "institutionTypeManager" = @DI\Inject("well_followed.institution_type_manager")
     * })
     */
    public function __construct(InstitutionTypeManager $institutionTypeManager)
    {
        $this->institutionTypeManager = $institutionTypeManager;
    }

    public function getAllowedScopes()
    {
        return ['access_institution_type'];
    }

    /**
     * @Route(" ", name="get_institution_types")
     * @Method({"GET"})
     * @FilterContent("WellFollowed\AppBundle\Manager\Filter\InstitutionTypeFilter")
     */
    public function getInstitutionTypesAction(Request $request)
    {
        $models = $this->institutionTypeManager
            ->getInstitutionTypes($request->attributes->get('filter'));

        return $this->jsonResponse($models);
    }

    /**
     * @Route("/{id}", name="get_institution_type", requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getInstitutionTypeAction(Request $request, $id)
    {
        $model = $this->institutionTypeManager
            ->getInstitutionType($id);

        return $this->jsonResponse($model);
    }

    /**
     * @Route(" ", name="create_institution_type")
     * @Method({"POST"})
     * @JsonContent("WellFollowed\AppBundle\Model\InstitutionType\InstitutionTypeModel")
     */
    public function createInstitutionTypeAction(Request $request)
    {
        $model = $this->institutionTypeManager
            ->createInstitutionType($request->attributes->get('json'));

        return $this->jsonResponse($model);
    }

    /**
     * @Route(" ", name="update_institution_type")
     * @Method({"PUT"})
     * @JsonContent("WellFollowed\AppBundle\Model\InstitutionType\InstitutionTypeModel")
     */
    public function updateInstitutionTypeAction(Request $request)
    {
        $model = $this->institutionTypeManager
            ->updateInstitutionType($request->attributes->get('json'));

        return $this->jsonResponse($model);
    }

    /**
     * @Route("/{id}", name="delete_institution_type", requirements={"id" = "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteInstitutionTypeAction(Request $request, $id)
    {
        $this->institutionTypeManager
            ->deleteInstitutionType($id);

        return $this->jsonResponse(null);
    }
}
