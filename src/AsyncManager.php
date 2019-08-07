<?php
namespace Async;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Throwable;

class AsyncManager extends Application
{
    protected $commands = [
        ListCommand::class,     // 查看异步进程
        StopCommand::class,     // 停止异步进程
    ];

    public function __construct()
    {
        parent::__construct();
        foreach ($this->commands as $command) {
            try {
                $instance = new $command();
            } catch (Throwable $e) {
                throw new CommandNotFoundException('命令: ' . $command . ' 未找到');
            }
            $this->add($instance);
        }
    }
}