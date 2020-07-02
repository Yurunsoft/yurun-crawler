<?php
namespace Yurun\Crawler\Tool;

use Imi\App;
use Imi\Tool\ArgType;
use Imi\Tool\Annotation\Arg;
use Imi\Tool\Annotation\Tool;
use Imi\Cron\Process\CronProcess;
use Imi\Process\Process;
use Imi\Tool\Annotation\Operation;
use Imi\Util\Args;
use Imi\Util\Imi;
use Swoole\Coroutine;
use Swoole\Runtime;

/**
 * @Tool("crawler")
 */
class CrawlerTool
{
    /**
     * 运行采集任务
     *
     * @Operation(name="run", co=false)
     * @Arg(name="name", type=ArgType::ARRAY, required=true, comments="采集任务名称，支持多个，以半角逗号分割")
     * @Arg(name="process", type=ArgType::INT, comments="进程数量")
     * @Arg(name="co", type=ArgType::INT, comments="每个进程中的协程数量")
     * 
     * @return void
     */
    public function run(array $name, ?int $process, ?int $co)
    {
        Runtime::enableCoroutine();
        $running = true;
        \Imi\Util\Process::signal(SIGTERM, function() use(&$running){
            $running = false;
        });
        // 启动队列消费进程
        go(function() use(&$running){
            /** @var \Imi\Log\ErrorLog $errorLog */
            $errorLog = App::getBean('ErrorLog');
            do {
                try {
                    $handler = proc_open('exec ' . Imi::getImiCmd('process', 'run', [
                        'name'  =>  'CrawlerQueueConsumer',
                    ]), [], $pipes, null, null, [
                        'bypass_shell'  =>   false,
                    ]);
                    do {
                        $status = proc_get_status($handler);
                        Coroutine::sleep(0.1);
                    } while(($status['running'] ?? false) && $running);
                    if(!$running && proc_terminate($handler))
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
            } while($running);
        });

        $tmpProcess = new Process(function(){});
        Args::set('cronSock', '/tmp/yurun-crawler-' . md5(App::getNamespace() . '#' . implode(',', $name)) . '.sock');
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
