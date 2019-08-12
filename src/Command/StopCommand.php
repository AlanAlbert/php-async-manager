<?php
namespace Async\Command;

use Async\AsyncManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Exception;

class StopCommand extends Command
{
    protected function configure()
    {
        $this->setName('Stop')
            ->addArgument('pid', InputArgument::REQUIRED, 'Process pid')
            ->setDescription('Stop a running async task.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pid = $input->getArgument('pid');
        $file = AsyncManager::PID_DIR . 'php-async-' . $pid . '.pid';
        if (!is_file($file)) {
            throw new Exception('pid file(' . $file . ') not found.');
        }
        posix_kill($pid, SIGTERM);
        unlink($file);
        $this->updatePidsFile($pid);
        $output->writeln("");
        $output->writeln("<info>Process {$pid} stop success!</info>");
    }

    private function updatePidsFile($pid)
    {
        if (is_file(AsyncManager::PID_DIR . AsyncManager::PIDS_FILE)) {
            $content = file_get_contents(AsyncManager::PID_DIR . AsyncManager::PIDS_FILE);
            $jobs = json_decode($content, true) ? json_decode($content, true) : [];
        } else {
            $jobs = [];
        }
        if (!isset($jobs[$pid])) {
            throw new Exception('Pids file error');
        }
        $jobs[$pid]['status']      = AsyncManager::STATUS_STOPPED;
        $jobs[$pid]['end_time']    = date('Y-m-d H:i:s');
        $content = json_encode($jobs);
        if (!file_put_contents(AsyncManager::PID_DIR . AsyncManager::PIDS_FILE, $content)) {
            throw new Exception('Write file error (' . self::PIDS_FILE . ')');
        }
    }
}