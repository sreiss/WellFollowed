<?php

namespace WellFollowedBundle\Controller\Api;

use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use UtilBundle\Annotation\JsonContent;
use Symfony\Component\HttpFoundation\Request;
use UtilBundle\Contract\Controller\JsonControllerInterface;
use WellFollowedBundle\Base\ApiController;
use WellFollowedBundle\Manager\InstitutionManager;

/**
 * Institution controller.
 *
 * @Route("/institution")
 */
class InstitutionController extends ApiController implements JsonControllerInterface
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
     * @Route(" ", name="get_institutions")
     * @Method({"GET"})
     */
    public function getInstitutionsAction(Request $request)
    {
        $model = $this->institutionManager
            ->getInstitutions($request->attributes->get('filter'));

        return $this->jsonResponse($model);
    }

    /**
     * @Route("/{id}", name="get_institution", requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function getInstitutionAction(Request $request, $id)
    {
        $model = $this->institutionManager
            ->getInstitution($id);

        return $this->jsonResponse($model);
    }

    /**
     * @Route(" ", name="create_institution")
     * @Method({"POST"})
     * @JsonContent("WellFollowedBundle\Model\Institution\InstitutionModel")
     */
    public function createInstitutionAction(Request $request)
    {
        $model = $this->institutionManager
            ->createInstitution($request->attributes->get('json'));

        return $this->jsonResponse($model);
    }

    /**
     * @Route(" ", name="update_institution")
     * @Method({"PUT"})
     * @JsonContent("WellFollowedBundle\Model\Institution\InstitutionModel")
     */
    public function updateInstitutionAction(Request $request)
    {
        $model = $this->institutionManager
            ->updateInstitution($request->attributes->get('json'));

        return $this->jsonResponse($model);
    }

    /**
     * @Route("/{id}", name="delete_institution", requirements={"id" = "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteInstitutionAction(Request $request, $id)
    {
        $this->institutionManager
            ->deleteInstitution($id);

        return $this->jsonResponse(null);
    }
}