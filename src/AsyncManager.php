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
        HelpCommand::class      // 帮助命令
    ];

    public function __construct()
    {
        foreach ($this->commands as $command) {
            try {
                $instance = new $command();
            } catch (Throwable $e) {
                throw CommandNotFoundException('命令:' . $command . '未找到');
            }
            $this->add($instance);
        }
    }
}