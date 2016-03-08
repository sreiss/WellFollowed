<?php

namespace WellFollowed\AppBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Manager\InstitutionTypeManager;
use WellFollowed\AppBundle\Model\InstitutionTypeModel;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class InstitutionTypeController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/institution-type")
 */
class InstitutionTypeController extends ApiController
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

    /**
     * @Rest\Get(" ", name="get_institution_types")
     * @Rest\View(serializerGroups={"list"})
     */
    public function getInstitutionTypesAction(ParamFetcher $fetcher)
    {
        $models = $this->institutionTypeManager
            ->getInstitutionTypes();

        return $models;
    }

    /**
     * @Rest\Get("/{id}", name="get_institution_type", requirements={"id" = "\d+"})
     */
    public function getInstitutionTypeAction(Request $request, $id)
    {
        return $this->institutionTypeManager
            ->getInstitutionType($id);
    }

    /**
     * @Rest\Post(" ", name="create_institution_type")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"details"}}})
     */
    public function createInstitutionTypeAction(InstitutionTypeModel $model)
    {
        return $this->institutionTypeManager
            ->createInstitutionType($model);
    }

    /**
     * @Rest\Put(" ", name="update_institution_type")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"details"}}})
     */
    public function updateInstitutionTypeAction(InstitutionTypeModel $model)
    {
        return $this->institutionTypeManager
            ->updateInstitutionType($model);
    }

    /**
     * @Rest\Delete("/{id}", name="delete_institution_type", requirements={"id" = "\d+"})
     */
    public function deleteInstitutionTypeAction(Request $request, $id)
    {
        return $this->institutionTypeManager
            ->deleteInstitutionType($id);
    }
}
