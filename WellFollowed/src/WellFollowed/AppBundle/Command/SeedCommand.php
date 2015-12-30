<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 08/12/2015
 * Time: 12:16
 */

namespace WellFollowed\AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellFollowed\AppBundle\Entity\InstitutionType;

class SeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wellfollowed:seed')
            ->setDescription('Inserts default data in database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $entities = [];

        $entities['iut'] = new InstitutionType();
        $entities['iut']->setTag('I.U.T.');

        foreach($entities as $entity) {
            $em->persist($entity);
        }
        $em->flush();
    }
}