<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 22:14
 */

namespace WellFollowedBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Oauth2InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wellfollowed:oauth2:install')
            ->setDescription("Installe la partie Oauth2 de l'application")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $scopeManager = $container->get('oauth2.scope_manager');
        $clientService = $container->get('well_followed.client_manager');
        $oauth2Scopes = $container->getParameter('oauth2_scopes');
        $oauth2PublicClients = $container->getParameter('oauth2_public_clients');

        try {
            foreach($oauth2Scopes as $scope => $description) {
                if (!$scopeManager->findScopeByScope($scope)) {
                    $scopeManager->createScope($scope, $description);
                    $output->writeln('<fg=green>Ajout du scope ' . $scope . '</fg=green>');
                }
            }

            foreach($oauth2PublicClients as $client => $scopes) {
                $clientService->createClient($client, array('http://localhost:8085'), array('password'), $scopes, true);
            }

        } catch (\Doctrine\DBAL\DBALException $e) {
            $output->writeln('<fg=red>Impossible de créer le scope</fg=red>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');

            return 1;
        }

        $output->writeln("<fg=green>Installation d'Oauth2 effectuée.</fg=green>");
    }
}