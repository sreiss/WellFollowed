<?php

namespace WellFollowed\AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use WellFollowed\AppBundle\Manager\Filter\UserFilter;
use WellFollowed\AppBundle\Model\UserModel;
use WellFollowed\AppBundle\Base\ErrorCode;
use WellFollowed\AppBundle\Base\WellFollowedException;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\UserBundle\Doctrine\UserManager as FOSUserManager;

/**
 * Class UserManager
 * @package WellFollowed\AppBundle\Service
 *
 * @DI\Service("well_followed.user_manager")
 */
class UserManager extends FOSUserManager
{
    /**
     * UserManager constructor.
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface $usernameCanonicalizer
     * @param CanonicalizerInterface $emailCanonicalizer
     * @param ObjectManager $om
     * @param string $class
     *
     * @DI\InjectParams({
     *     "encoderFactory" = @DI\Inject("security.encoder_factory"),
     *     "usernameCanonicalizer" = @DI\Inject("fos_user.util.username_canonicalizer"),
     *     "emailCanonicalizer" = @DI\Inject("fos_user.util.email_canonicalizer"),
     *     "om" = @DI\Inject("fos_user.entity_manager"),
     *     "class" = @DI\Inject("%fos_user.model.user.class%")
     * })
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);
    }

    public function getUsers(UserFilter $filter = null)
    {
        $models = [];
        $qb = $this->repository
            ->createQueryBuilder('u');

        if ($filter !== null) {
            if (!empty($filter->getUsernames())) {
                $qb->where($qb->expr()->in('u.username', $filter->getUsernames()));
            }
        }

        $users = $qb->getQuery()
            ->getResult();

        foreach ($users as $user) {
            $model = new UserModel($user);
            $models[] = $model;
        }

        return $models;
    }

    public function getUser($username)
    {
        $user = $this->findUserByUsername($username);

        if ($user === null)
            throw new WellFollowedException(ErrorCode::NOT_FOUND);

        return new UserModel($user);
    }

    public function createWfUser(UserModel $model)
    {
        if ($model === null)
            throw new WellFollowedException(ErrorCode::NO_MODEL_PROVIDED);

        $user = $this->createUser();
        $user->setEmail($model->getEmail());
        $user->setUsername($model->getUsername());
        $user->setPlainPassword($model->getPassword());
        $user->setLastName($model->getLastName());
        $user->setFirstName($model->getFirstName());
        $user->setSubscriptionDate(new \DateTime());
        $user->setEnabled(true);
        $this->updateUser($user);

        return new UserModel($user);
    }
}