<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\DiExtraBundle\Annotation as DI;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use WellFollowed\AppBundle\Entity\Institution;
use WellFollowed\AppBundle\Model\InstitutionModel;
use WellFollowed\AppBundle\Model\InstitutionTypeModel;

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

    public function  getInstitutions(ParamFetcher $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Institution')
            ->createQueryBuilder('i');

        if (!is_null($filter))
        {
            // TODO: handle filter
        }

        $models = [];
        $institutions = $qb->getQuery()
            ->getResult();

        foreach ($institutions as $institution) {
            $model = new InstitutionModel($institution);
            $models[] = $model;
        }

        return $models;
    }

    public function getInstitution($id)
    {
        $institution = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Institution')
            ->find($id);

        if ($institution === null)
            throw new WellFollowedException(ErrorCode::NOT_FOUND);

        return new InstitutionModel($institution);
    }

    public function createInstitution(InstitutionModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        $existingInstitution = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Institution')
            ->findOneBy(array('tag' => $model->getTag()));

        if ($existingInstitution !== null)
            throw new WellFollowedException(ErrorCode::INSTITUTION_EXISTS);

        $institutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->find($model->getType()->getId());

        $institution = new Institution();
        $institution->setTag($model->getTag());
        $institution->setType($institutionType);

        $this->entityManager->persist($institution);
        $this->entityManager->flush();

        return new InstitutionModel($institution);
    }

    public function updateInstitution(InstitutionModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        if ($model->getId() === null)
            throw new WellFollowedException(ErrorCode::AN_ID_MUST_BE_PROVIDED);

        $existingInstitution = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Institution')
            ->findOneBy(array('tag' => $model->getTag()));

        $institution = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Institution')
            ->find($model->getId());

        if ($existingInstitution !== null && $institution->getTag() !== $existingInstitution->getTag())
            throw new WellFollowedException(ErrorCode::INSTITUTION_EXISTS);

        $institutionType = $this->entityManager
            ->getRepository('WellFollowedAppBundle:InstitutionType')
            ->find($model->getType()->getId());

        $institution->setTag($model->getTag());
        $institution->setType($institutionType);

        $this->entityManager->flush();

        return new InstitutionModel($institution);
    }

    public function deleteInstitution($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $qb = $this->entityManager
                ->getRepository('WellFollowedAppBundle:Institution')
                ->createQueryBuilder('i');

            $qb->delete('WellFollowed\AppBundle\Entity\Institution', 'i')
                ->where('i.id = :id')
                ->setParameter('id', $id);

            return $qb->getQuery()
                ->execute();
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}