<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use WellFollowed\AppBundle\Base\ErrorCode;
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
     * @param $id
     * @return EventModel
     */
    public function getEvent($id)
    {
        $event = $this->getEventAsEntity($id);

        return new EventModel($event);
    }

    /**
     * @param $id
     * @return Event
     */
    public function getEventAsEntity($id)
    {
        return $this->entityManager
            ->getRepository('WellFollowedAppBundle:Event')
            ->find($id);
    }

    /**
     * @param array|null $filter
     * @return \WellFollowed\AppBundle\Entity\Event[]
     */
    public function getEvents(EventFilter $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedAppBundle:Event')
            ->createQueryBuilder('e');

        if ($filter !== null)
        {
            // We take into account the end of the first event matched and the end of the last one
            // in order to be consistent.
            if ($filter->getStart() !== null)
                $qb->andWhere('e.end > :start')
                    ->setParameter('start', $filter->getStart());
            if ($filter->getEnd() !== null)
                $qb->andWhere('e.end < :end')
                    ->setParameter('end', $filter->getEnd());
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
        $event->setCancelled(false);

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $model->setId($event->getId());

        return $model;
    }

    public function deleteEvent($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $event = $this->entityManager
                ->getRepository('WellFollowedAppBundle:Event')
                ->find($id);

            if ($event === null)
                throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);

            $event->setCancelled(true);

            $this->entityManager->persist($event);
            $this->entityManager->flush();

            return true;
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
}
