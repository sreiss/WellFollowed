<?php

namespace WellFollowedBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowedBundle\Base\ApiController;
use WellFollowedBundle\Entity\InstitutionType;
use WellFollowedBundle\Form\InstitutionTypeType;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Manager\InstitutionTypeManager;
use UtilBundle\Annotation\FilterContent;
use UtilBundle\Annotation\JsonContent;

/**
 * InstitutionType controller.
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

    /**
     * @Route(" ", name="get_institution_types")
     * @Method({"GET"})
     */
    public function getInstitutionTypesAction(Request $request)
    {
        $model = $this->institutionTypeManager
            ->getInstitutionTypes($request->attributes->get('filter'));

        return $this->jsonResponse($model);
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
     * @JsonContent("WellFollowedBundle\Model\InstitutionType\InstitutionTypeModel")
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
     * @JsonContent("WellFollowedBundle\Model\InstitutionType\InstitutionTypeModel")
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
