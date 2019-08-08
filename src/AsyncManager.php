<?php
namespace Async;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Throwable;

class AsyncManager extends Application
{   
    /**
     * PID文件存放目录
     * 
     * @var		string	PID_DIR           
     */
    const PID_DIR           = '/tmp/php-async-pid/';

    /**
     * PIDS文件，存各个守护程序的信息
     * 
     * @var		string	PIDS_FILE           
     */
    const PIDS_FILE         = 'php-async.pids';        

    /**
     * 进程运行状态：运行中
     * 
     * @var		string	STATUS_RUNNING      
     */
    const STATUS_RUNNING    = 'RUNNING';  

    /**
     * 进程运行状态：已停止
     * 
     * @var		string	STATUS_STOPPED      
     */
    const STATUS_STOPPED    = 'STOPPED';                
    
    /**
     * 进程运行状态：已完成
     * 
     * @var		string	STATUS_COMPLETED    
     */
    const STATUS_COMPLETED  = 'COMPLETED';  

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

        // 设置默认命令为help
        $this->setDefaultCommand('help');
    }
}