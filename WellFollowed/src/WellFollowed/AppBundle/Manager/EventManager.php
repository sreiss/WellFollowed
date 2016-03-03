<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Request\ParamFetcher;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\ResponseFormat;
use WellFollowed\AppBundle\Base\WellFollowedException;
use WellFollowed\AppBundle\Entity\Event;
use WellFollowed\AppBundle\Manager\Filter\EventFilter;
use WellFollowed\AppBundle\Model\EventModel;
use WellFollowed\AppBundle\Model\UserModel;

use JMS\DiExtraBundle\Annotation as DI;

/** @DI\Service("well_followed.event_manager") */
class EventManager
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

    /**
     * @param array|null $filter
     * @return \WellFollowed\AppBundle\Entity\Event[]
     */
    public function getEvents(ParamFetcher $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Event')
            ->createQueryBuilder('e');

        if ($filter !== null)
        {
            // We take into account the end of the first event matched and the end of the last one
            // in order to be consistent.
            if ($filter->get('start') !== null)
                $qb->andWhere('e.end > :start')
                    ->setParameter('start', $filter->get('start'));
            if ($filter->get('end') !== null)
                $qb->andWhere('e.end < :end')
                    ->setParameter('end', $filter->get('end'));
        }

        $models = array();
        $events = $qb->getQuery()
//                    ->join('e.User', 'u', 'WITH', 'u.id = ?1', 'e.user_id')
            ->getResult();

        foreach ($events as $event)
        {
            $userModel = null;
            if ($user = $event->getUser() != null)
                $userModel = new UserModel($user);
            $models[] = new EventModel($event, $userModel);
        }

        return $models;
    }

    public function createEvent(EventModel $model)
    {
        $event = new Event();
        $event->setTitle($model->getTitle());
        $event->setStart($model->getStart());
        $event->setEnd($model->getEnd());
        $event->setDescription($model->getDescription());

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $model;
    }

    public function deleteEvent($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $qb = $this->entityManager
                ->getRepository('WellFollowedAppBundle:Event')
                ->createQueryBuilder('e');

            $qb->delete('WellFollowed\AppBundle\Entity\Event', 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $deletedCount = $qb->getQuery()
                ->execute();

            if ($deletedCount == 0)
                throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);

            return true;
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}
