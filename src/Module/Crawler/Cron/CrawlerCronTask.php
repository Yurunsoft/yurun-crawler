<?php
namespace Yurun\Crawler\Module\Crawler\Cron;

use Imi\Cron\Contract\ICronTask;

/**
 * 定时采集任务类
 */
class CrawlerCronTask implements ICronTask
{
    /**
     * 执行任务
     *
     * @param string $id
     * @param mixed $data
     * @return void
     */
    public function run(string $id, $data)
    {
        var_dump('CrawlerCronTask');
    }

}
