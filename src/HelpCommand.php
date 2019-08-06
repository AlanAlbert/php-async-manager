<?php
namespace Async;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelpCommand extends Command
{
    protected function configure()
    {
        $this->setName('help');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Help');
    }
}