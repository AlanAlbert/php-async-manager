<?php
namespace Async;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class ListCommand extends Command
{
    protected function configure()
    {
        $this->setName('list')
            ->setAliases(['ls', 'l'])
            ->addOption('filter', 'f', InputOption::VALUE_OPTIONAL, 'The option allows [<info>a</info>(ll), <info>r</info>(unning), <info>s</info>(topped), <info>c</info>(ompleted)]')
            ->setDescription('list async jobs')
            ->setHelp('The command allows you to get this async jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump($input->getOptions());
    }
}