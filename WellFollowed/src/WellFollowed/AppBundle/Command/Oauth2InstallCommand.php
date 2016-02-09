<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 22:14
 */

namespace WellFollowed\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellFollowed\AppBundle\Model\UserModel;
use WellFollowed\OAuth2\ServerBundle\Entity\User;

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
        $clientManager = $container->get('oauth2.client_manager');
        //$clientService = $container->get('well_followed.client_manager');
        $oauth2Scopes = $container->getParameter('oauth2_scopes');
        //$oauth2PublicClients = $container->getParameter('oauth2_public_clients');
        $oauth2Clients = $container->getParameter('oauth2_clients');
        $userManager = $container->get('well_followed.user_manager');

        try {
            foreach($oauth2Scopes as $scope => $description) {
                if (!$scopeManager->findScopeByScope($scope)) {
                    $scopeManager->createScope($scope, $description);
                    $output->writeln('<fg=green>Ajout du scope ' . $scope . '</fg=green>');
                }
            }

            foreach($oauth2Clients as $clientId => $config) {
                if ($clientManager->getClient($clientId) === null)
                {
                    $clientManager->createClient(
                        $clientId,
                        ($config['redirect_uris'] === null) ? [] : $config['redirect_uris'],
                        ($config['grant_types'] === null) ? [] : $config['grant_types'],
                        ($config['scopes'] === null) ? [] : $config['scopes']
                    );
                }
                else
                {
                    $output->writeln('<fg=yellow>Le client '. $clientId .' était déjà présent en base.</fg=yellow>');
                }
            }
        } catch (\Doctrine\DBAL\DBALException $e) {
            $output->writeln('<fg=red>Impossible de créer le scope</fg=red>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');

            return 1;
        }

        $output->writeln("<fg=green>Installation d'Oauth2 effectuée.</fg=green>");
    }
}