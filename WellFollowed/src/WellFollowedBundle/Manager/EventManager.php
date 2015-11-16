<?php

namespace WellFollowedBundle\Manager;

use Doctrine\ORM\EntityManager;
use WellFollowedBundle\Base\ErrorCode;
use WellFollowedBundle\Base\Filter\ResponseFormat;
use WellFollowedBundle\Base\WellFollowedException;
use WellFollowedBundle\Contract\Manager\EventManagerInterface;
use WellFollowedBundle\Entity\Event;
use WellFollowedBundle\Entity\User;
use WellFollowedBundle\Manager\Filter\EventFilter;
use WellFollowedBundle\Model\Event\EventModel;
use WellFollowedBundle\Model\User\UserModel;

use JMS\DiExtraBundle\Annotation as DI;

/** @DI\Service("well_followed.event_manager") */
class EventManager implements EventManagerInterface
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
     * @return \WellFollowedBundle\Entity\Event[]
     */
    public function getEvents(EventFilter $filter = null)
    {
        $qb = $this->entityManager
            ->getRepository('WellFollowedBundle:Event')
            ->createQueryBuilder('e');

        if (!is_null($filter))
        {
            // We take into account the end of the first event matched and the end of the last one
            // in order to be consistent.
            if (!is_null($filter->getStart()))
                $qb->andWhere('e.end > :start')
                    ->setParameter('start', $filter->getStart());
            if (!is_null($filter->getEnd()))
                $qb->andWhere('e.end < :end')
                    ->setParameter('end', $filter->getEnd());
            if (!is_null($filter->getFormat()) && $filter->getFormat() == ResponseFormat::FULL_FORMAT)
            {
                $models = array();
                $events = $qb->getQuery()
//                    ->join('e.User', 'u', 'WITH', 'u.id = ?1', 'e.user_id')
                    ->getResult();

                foreach ($events as $event)
                {
                    $userModel = null;
                    if (!is_null($user = $event->getUser()))
                        $userModel = new UserModel($userModel);
                    $models[] = new EventModel($event, $userModel);
                }

                return $models;
            }

        }

        return null;
    }

    public function createEvent(Event $event)
    {
//        $event = new Event();
//        $event->setTitle($model->getTitle());
//        $event->setStart($model->getStart());
//        $event->setEnd($model->getEnd());
//        $event->setDescription($model->getDescription());

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $event;
    }

    public function deleteEvent($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $qb = $this->entityManager
                ->getRepository('WellFollowedBundle:Event')
                ->createQueryBuilder('e');

            $qb->delete('WellFollowedBundle\Entity\Event', 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            return $qb->getQuery()
                ->execute();
        }

        throw new WellFollowedException(ErrorCode::NOT_FOUND, null, 404);
    }
//    public function getEvents($filter) {
//        $events = $this->eventRepository->findEvents($filter);
//        $models = array();
//        foreach ($events as $event) {
//            $model = new EventModel();
//            $model->setId($event->getId());
//            $model->setDescription($event->getDescription());
//            $model->setEnd($event->getEnd());
//            $model->setStart($event->getStart());
//            $model->setUser(new UserModel($event->getUser()));
//        }
//    }
}
