<?php

namespace Async\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected function configure()
    {
        $this->setName('list')
            ->setDescription("List all available commands.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $output->writeln("");
        $output->writeln("<info>Pam</info> <comment>1.0.0</comment>");
        $output->writeln("  PHP Async Manager.");
        $output->writeln("  <comment>Manage PHP Async Task </comment>(forked by this repo --- <info>alanalbert/php-async</info>).");
        $output->writeln("");

        $output->writeln("<comment>Usage:</comment>");
        $output->writeln("  command [options] [arguments]");
        $output->writeln("");

        $output->writeln("<comment>Available commands:</comment>");
        $output->writeln("  <info>task</info>\t🔍  Show async tasks info.");
        $output->writeln("  <info>stop</info>\t⚡   Stop a running async task.");
        $output->writeln("  <info>list</info>\t🕵  List all available commands.");
        $output->writeln("");
    }
}
