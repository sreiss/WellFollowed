<?php

namespace WellFollowed\AppBundle\Controller\Api;

use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use WellFollowed\AppBundle\Base\ApiController;
use WellFollowed\AppBundle\Manager\InstitutionManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use WellFollowed\AppBundle\Model\InstitutionModel;

/**
 * Class InstitutionController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/institution")
 */
class InstitutionController extends ApiController
{
    private $institutionManager;

    /**
     * @DI\InjectParams({
     *      "institutionManager" = @DI\Inject("well_followed.institution_manager")
     * })
     */
    public function __construct(InstitutionManager $institutionManager)
    {
        $this->institutionManager = $institutionManager;
    }

    /**
     * @Rest\Get(" ", name="get_institutions")
     * @Security("has_role('READ_INSTITUTION')")
     */
    public function getInstitutionsAction(Request $request)
    {
        return $this->institutionManager
            ->getInstitutions();
    }

    /**
     * @Rest\Get("/{id}", name="get_institution", requirements={"id" = "\d+"})
     * @Security("has_role('READ_INSTITUTION')")
     */
    public function getInstitutionAction(Request $request, $id)
    {
        return $this->institutionManager
            ->getInstitution($id);
    }

    /**
     * @Rest\Post(" ", name="create_institution")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"details"}}})
     * @Security("has_role('CREATE_INSTITUTION')")
     */
    public function createInstitutionAction(InstitutionModel $model)
    {
        return $this->institutionManager
            ->createInstitution($model);
    }

    /**
     * @Rest\Put(" ", name="update_institution")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"details"}}})
     * @Security("has_role('UPDATE_INSTITUTION')")
     */
    public function updateInstitutionAction(InstitutionModel $model)
    {
        return $this->institutionManager
            ->updateInstitution($model);
    }

    /**
     * @Rest\Delete("/{id}", name="delete_institution", requirements={"id" = "\d+"})
     * @Security("has_role('DELETE_INSTITUTION')")
     */
    public function deleteInstitutionAction(Request $request, $id)
    {
        return $this->institutionManager
            ->deleteInstitution($id);
    }
}