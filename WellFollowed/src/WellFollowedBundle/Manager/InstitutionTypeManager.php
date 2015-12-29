<?php

namespace WellFollowedBundle\Manager;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\Filter\ResponseFormat;
use WellFollowedBundle\Base\WellFollowedException;
use WellFollowedBundle\Entity\InstitutionType;
use WellFollowedBundle\Manager\Filter\InstitutionTypeFilter;
use WellFollowedBundle\Model\Common\ListModel;
use WellFollowedBundle\Model\InstitutionType\InstitutionTypeModel;

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
            ->getRepository('WellFollowedBundle:InstitutionType')
            ->createQueryBuilder('it');

        if (!is_null($filter))
        {
            // TODO: handle filter
        }

        $models = [];
        $institutionTypes = $qb->getQuery()
            ->getResult();

        foreach ($institutionTypes as $institutionType) {
            $model = new ListModel();
            $model->setTag($institutionType->getTag());
            $model->setId($institutionType->getId());
            $models[] = $model;
        }

        return $models;
    }

    public function getInstitutionType($id)
    {
        $institutionType = $this->entityManager
            ->getRepository('WellFollowedBundle:InstitutionType')
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
            ->getRepository('WellFollowedBundle:InstitutionType')
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
            ->getRepository('WellFollowedBundle:InstitutionType')
            ->findOneBy(array('tag' => $model->getTag()));

        $institutionType = $this->entityManager
            ->getRepository('WellFollowedBundle:InstitutionType')
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
                ->getRepository('WellFollowedBundle:InstitutionType')
                ->createQueryBuilder('it');

            $qb->delete('WellFollowedBundle\Entity\InstitutionType', 'it')
                ->where('it.id = :id')
                ->setParameter('id', $id);

            return $qb->getQuery()
                ->execute();
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}