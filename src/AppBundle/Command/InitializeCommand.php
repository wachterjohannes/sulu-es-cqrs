<?php

namespace AppBundle\Command;

use Prooph\EventStore\Adapter\Doctrine\Schema\EventStoreSchema;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:initialize');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        $from = $connection->getSchemaManager()->createSchema();
        $to = clone $from;

        EventStoreSchema::createSingleStream($to, 'event_stream', true);
        $statements = $from->getMigrateToSql($to, $connection->getDatabasePlatform());

        foreach ($statements as $statement) {
            $connection->exec($statement);
        }
    }
}
