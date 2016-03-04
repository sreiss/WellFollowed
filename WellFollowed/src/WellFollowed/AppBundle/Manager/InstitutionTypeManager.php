<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\ResponseFormat;
use WellFollowed\AppBundle\Base\WellFollowedException;
use WellFollowed\AppBundle\Entity\InstitutionType;
use WellFollowed\AppBundle\Manager\Filter\InstitutionTypeFilter;
use WellFollowed\AppBundle\Model\InstitutionTypeModel;

/** @DI\Service("well_followed.institution_type_manager") */
class InstitutionTypeManager
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

    public function  getInstitutionTypes(InstitutionTypeFilter $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->createQueryBuilder('it');

        if (!is_null($filter))
        {
            // TODO: handle filter
        }

        $models = [];
        $institutionTypes = $qb->getQuery()
            ->getResult();

        foreach ($institutionTypes as $institutionType) {
            $model = new InstitutionTypeModel($institutionType);
            $models[] = $model;
        }

        return $models;
    }

    public function getInstitutionType($id)
    {
        $institutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->find($id);

        if ($institutionType === null)
            throw new WellFollowedException(ErrorCode::NOT_FOUND);

        return new InstitutionTypeModel($institutionType);
    }

    public function createInstitutionType(InstitutionTypeModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        $existingInstitutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->findOneBy(array('tag' => $model->getTag()));

        if ($existingInstitutionType !== null)
            throw new WellFollowedException(ErrorCode::INSTITUTION_TYPE_EXISTS);

        $institutionType = new InstitutionType();
        $institutionType->setTag($model->getTag());

        $this->entityManager->persist($institutionType);
        $this->entityManager->flush();

        return new InstitutionTypeModel($institutionType);
    }

    public function updateInstitutionType(InstitutionTypeModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        if ($model->getId() === null)
            throw new WellFollowedException(ErrorCode::AN_ID_MUST_BE_PROVIDED);

        $existingInstitutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->findOneBy(array('tag' => $model->getTag()));

        $institutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->find($model->getId());

        if ($existingInstitutionType !== null && $institutionType->getTag() !== $existingInstitutionType->getTag())
            throw new WellFollowedException(ErrorCode::INSTITUTION_TYPE_EXISTS);

        $institutionType->setTag($model->getTag());

        $this->entityManager->flush();

        return new InstitutionTypeModel($institutionType);
    }

    public function deleteInstitutionType($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $qb = $this->entityManager
                ->getRepository('WellFollowedAppBundle:InstitutionType')
                ->createQueryBuilder('it');

            $qb->delete('WellFollowed\AppBundle\Entity\InstitutionType', 'it')
                ->where('it.id = :id')
                ->setParameter('id', $id);

            return $qb->getQuery()
                ->execute();
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}