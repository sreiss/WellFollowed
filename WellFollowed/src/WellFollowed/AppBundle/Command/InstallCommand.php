<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 22:08
 */

namespace WellFollowed\AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wellfollowed:install')
            ->setDescription('Installs the WellFollowed application')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $clientManager = $container->get('oauth2.client_manager');

        try {
            $client = $clientManager->createClient(
                $input->getArgument('identifier'),
                explode(',', $input->getArgument('redirect_uri')),
                explode(',', $input->getArgument('grant_types')),
                explode(',', $input->getArgument('scopes'))
            );
        } catch (\Doctrine\DBAL\DBALException $e) {
            $output->writeln('<fg=red>Unable to create client ' . $input->getArgument('identifier') . '</fg=red>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');

            return 1;
        } catch (\OAuth2\ServerBundle\Exception\ScopeNotFoundException $e) {
            $output->writeln('<fg=red>Scope not found, please create it first</fg=red>');

            return 1;
        }

        $output->writeln('<fg=green>Client ' . $input->getArgument('identifier') . ' created with secret ' . $client->getClientSecret() . '</fg=green>');
    }
}