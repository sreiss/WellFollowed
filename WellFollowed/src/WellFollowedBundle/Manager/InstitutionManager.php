<?php

namespace WellFollowedBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;

/** @DI\Service("well_followed.institution_manager") */
class InstitutionManager
{
    private $entityManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function  createInstitution()
    {

    }
}