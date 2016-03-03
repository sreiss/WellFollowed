<?php

namespace WellFollowed\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('wellfollowed:app:install')
            ->setDescription('Installs WellFollowed app')
            ->addArgument(
                'redirecturis',
                InputArgument::IS_ARRAY,
                "The redirect uris of the client (usually, the app's domain"
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command will install WellFollowed app by creating an oauth2 client.

  <info>php %command.full_name%</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');

        if (count($redirectUris = $input->getArgument('redirecturis')) == 0) {
            $output->writeln('<fg=red>Please provide a redirect uri for the client</fg=red>');
            return 1;
        }

        try {
            $client = $clientManager->createClient();
            $client->setRedirectUris($redirectUris);
            $client->setAllowedGrantTypes(array('password'));
            $clientManager->updateClient($client);
        } catch (\Doctrine\DBAL\DBALException $e) {
            $output->writeln('<fg=red>Unable to create client ' . $input->getArgument('identifier') . '</fg=red>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');

            return 1;
        } catch (\Exception $e) {
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');

            return 1;
        }

        $output->writeln('<fg=green>WellFollowed successfully installed.</fg=green>');
        return 0;
    }
}