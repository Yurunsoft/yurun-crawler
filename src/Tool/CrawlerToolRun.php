<?php
namespace Yurun\Crawler\Tool;

use Imi\App;
use Imi\Util\Imi;
use Imi\Util\Args;
use Swoole\Runtime;
use Imi\Tool\ArgType;
use Swoole\Coroutine;
use Imi\Process\Process;
use Imi\Tool\Annotation\Arg;
use Imi\Tool\Annotation\Tool;
use Imi\Aop\Annotation\Inject;
use Imi\Bean\Traits\TAutoInject;
use Imi\Cron\Process\CronProcess;
use Imi\Util\Process\ProcessType;
use Imi\Tool\Annotation\Operation;
use Imi\Util\Process\ProcessAppContexts;

/**
 * @Tool("crawler")
 */
class CrawlerToolRun
{
    use TAutoInject;

    /**
     * 是否正在运行采集任务
     *
     * @var boolean
     */
    protected $running = false;

    /**
     * @Inject("CrawlerManager")
     *
     * @var \Yurun\Crawler\Module\Crawler\Service\CrawlerManager
     */
    protected $crawlerManager;

    /**
     * 运行采集任务
     *
     * @Operation(name="run", co=false)
     * @Arg(name="name", type=ArgType::ARRAY, default={}, comments="采集任务名称，支持多个，以半角逗号分割")
     * @Arg(name="process", type=ArgType::INT, comments="进程数量")
     * @Arg(name="co", type=ArgType::INT, comments="每个进程中的协程数量")
     * 
     * @return void
     */
    public function run(array $name, ?int $process, ?int $co)
    {
        // 启用一键协程化
        Runtime::enableCoroutine();

        // 终止信号监听
        \Imi\Util\Process::signal(SIGTERM, function(){
            $this->running = false;
        });

        // 设置进程类型
        App::set(ProcessAppContexts::PROCESS_TYPE, ProcessType::PROCESS);

        // 定时任务需要的 Unix Socket 文件定义
        $cronSock = '/tmp/yurun-crawler-' . md5(App::getNamespace() . '#' . implode(',', $name)) . '.sock';
        App::set('cronSock', $cronSock);
        Args::set('cronSock', $cronSock);

        // 名称处理
        if(!$name)
        {
            $name = $this->crawlerManager->getAllNames();
        }
        if(!$name)
        {
            throw new \RuntimeException('Please develop the crawler code before running the crawler task');
        }

        // 运行中
        $this->running = true;

        foreach($name as $beanName)
        {
            /** @var \Yurun\Crawler\Module\Crawler\Contract\ICrawler $bean */
            $bean = $this->crawlerManager->getBean($beanName);
            $bean->start();
        }

        // 启动所需进程
        $this->startProcesses();
    }

    /**
     * 启动所需进程
     *
     * @return void
     */
    protected function startProcesses()
    {
        // 启动队列消费进程
        go(function() {
            /** @var \Imi\Log\ErrorLog $errorLog */
            $errorLog = App::getBean('ErrorLog');
            do {
                try {
                    $handler = proc_open('exec ' . Imi::getImiCmd('process', 'run', [
                        'name'      =>  'CrawlerQueueConsumer',
                        'cronSock'  =>  App::get('cronSock'),
                    ]), [], $pipes, null, null, [
                        'bypass_shell'  =>   false,
                    ]);
                    do {
                        $status = proc_get_status($handler);
                        Coroutine::sleep(0.1);
                    } while(($status['running'] ?? false) && $this->running);
                    if(!$this->running && proc_terminate($handler))
                    {
                        for($i = 0; $i < 30; ++$i)
                        {
                            $status = proc_get_status($handler);
                            if(!($status['running'] ?? false))
                            {
                                break;
                            }
                            Coroutine::sleep(0.1);
                        }
                    }
                    proc_close($handler);
                } catch(\Throwable $th) {
                    $errorLog->onException($th);
                }
            } while($this->running);
        });

        $tmpProcess = new Process(function(){});
        // 启动定时任务
        go(function() use(&$running, $tmpProcess){
            /** @var \Imi\Log\ErrorLog $errorLog */
            $errorLog = App::getBean('ErrorLog');
            try {
                /** @var CronProcess $cronProcess */
                $cronProcess = App::getBean(CronProcess::class);
                $cronProcess->run($tmpProcess);
            } catch(\Throwable $th) {
                $errorLog->onException($th);
            }
        });
    }

}
