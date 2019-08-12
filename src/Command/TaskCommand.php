<?php
namespace Async\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\Table;
use Async\AsyncManager;
use Exception;

class TaskCommand extends Command
{
    /**
     * 配置list命令
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('task')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'When the option is enabled, list all async process info.')
            ->addOption('running', 'r', InputOption::VALUE_NONE, 'List running async process info.')
            ->addOption('stopped', 's', InputOption::VALUE_NONE, 'List stopped async process info.')
            ->addOption('completed', 'c', InputOption::VALUE_NONE, 'List completed async process info.')
            ->setDescription('list async jobs')
            ->setHelp('The command allows you to get this async jobs');
    }

    /**
     * list命令具体逻辑
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filterOptions = $input->getOptions();
        if ($filterOptions['running']) {
            $asyncs = $this->parsePidsFile(AsyncManager::STATUS_RUNNING);
            $this->render($asyncs, $output);
        } elseif ($filterOptions['stopped']) {
            $asyncs = $this->parsePidsFile(AsyncManager::STATUS_STOPPED);
            $this->render($asyncs, $output);
        } elseif ($filterOptions['completed']) {
            $asyncs = $this->parsePidsFile(AsyncManager::STATUS_COMPLETED);
            $this->render($asyncs, $output);
        } elseif ($filterOptions['all'] || 
            !($filterOptions['all'] || 
            $filterOptions['running'] || 
            $filterOptions['stopped'] ||
            $filterOptions['completed'])) {
            $asyncs = $this->parsePidsFile();
            $this->render($asyncs, $output);
        }

    }

    /**
     * 解析pids文件
     *
     * @param string $type
     * @return void
     */
    private function parsePidsFile($type = 'all')
    {
        $pidsFile = AsyncManager::PID_DIR . AsyncManager::PIDS_FILE;
        if (!is_file($pidsFile)) {
            return [];
        }
        $asyncs = json_decode(file_get_contents($pidsFile), true);
        if ($asyncs === false) {
            throw new Exception('打开文件' . $pidsFile . '失败(可能权限不足)');
        }

        // 返回全部
        if ($type === 'all') {
            return $asyncs;
        }

        // 过滤不符合参数状态的数据
        $asyncs = array_filter($asyncs, function ($async) use ($type) {
            return $async['status'] == $type;
        });

        return $asyncs;
    }

    /**
     * 渲染
     *
     * @param array $asyncs
     * @param OutputInterface $output
     *
     * @return void
     */
    private function render($asyncs, OutputInterface $output)
    {
        // 重构数据
        $rows = [];
        foreach ($asyncs as $pid => $async) {
            // 为不同状态加上颜色
            switch ($async['status']) {
                case AsyncManager::STATUS_RUNNING:
                    $async['status'] = '<comment>'.$async['status'].'</comment>';
                    break;
                case AsyncManager::STATUS_STOPPED:
                    $async['status'] = '<error>'.$async['status'].'</error>';
                    break;
                case AsyncManager::STATUS_COMPLETED:
                    $async['status'] = '<info>'.$async['status'].'</info>';
                    break;
                default: 
                    break;
            }

            $rows[] = [
                'pid'           => $pid,
                'status'        => $async['status'],
                'start_time'    => $async['start_time'],
                'end_time'      => $async['end_time']
            ];
        }
        
        // 渲染到表格
        $table = new Table($output);
        $table->setHeaderTitle('Async Tasks Info');
        $table->setFooterTitle('Async Tasks Info');
        $table->setHeaders(['PID', 'STATUS', 'START_TIME', 'END_TIME'])
            ->addRows($rows);
        $table->render();
    }
}