<?php

namespace WellFollowed\AppBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use WellFollowed\AppBundle\Manager\EventManager;
use WellFollowed\AppBundle\Base\ApiController;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use WellFollowed\AppBundle\Manager\Filter\EventFilter;
use WellFollowed\AppBundle\Model\EventModel;
use WellFollowed\AppBundle\Model\UserModel;

/**
 * Class EventController
 * @package WellFollowed\AppBundle\Controller\Api
 *
 * @Rest\Route("/event")
 */
class EventController extends ApiController
{
    private $eventManager;

    /**
     * @DI\InjectParams({
     *      "eventManager" = @DI\Inject("well_followed.event_manager")
     * })
     */
    public function __construct(EventManager $eventManager) {
        $this->eventManager = $eventManager;
    }

    /**
     * @Rest\Get(" ", name="get_events")
     * @Rest\View(serializerGroups={"list"})
     * @Rest\QueryParam(name="start", requirements="[0-9]{4}\-[0-1][0-9]-[0-3][0-9]\T[0-9]{2}\:[0-9]{2}\:[0-9]{2}\.[0-9]{3}[Z]?", default=null, nullable=true)
     * @Rest\QueryParam(name="end", requirements="[0-9]{4}\-[0-1][0-9]-[0-3][0-9]\T[0-9]{2}\:[0-9]{2}\:[0-9]{2}\.[0-9]{3}[Z]?", default=null, nullable=true)
     * @Security("has_role('READ_EVENT')")
     */
    public function getEventsAction(ParamFetcher $fetcher)
    {
        $filter = new EventFilter();
        $filter->setStart($fetcher->get('start'));
        $filter->setEnd($fetcher->get('end'));

        return $this->eventManager
            ->getEvents($filter);
    }

    /**
     * @Rest\Post(" ", name="post_event")
     * @ParamConverter("model", options={"deserializationContext"={"groups"={"details"}}})
     * @Security("has_role('CREATE_EVENT')")
     */
    public function createEventAction(EventModel $model)
    {
        $model->setUser(new UserModel($this->getUser()));
        return $this->eventManager
            ->createEvent($model);
    }

    /**
     * @Rest\Delete("/{id}", name="delete_event", requirements={"id" = "\d+"}))
     * @Security("has_role('DELETE_EVENT')")
     */
    public function deleteEventAction(Request $request, $id) {
        return $this->eventManager
            ->deleteEvent($id);
    }
}