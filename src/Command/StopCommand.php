<?php
namespace Async\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StopCommand extends Command
{
    protected function configure()
    {
        $this->setName('Stop');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('停止');
    }
}