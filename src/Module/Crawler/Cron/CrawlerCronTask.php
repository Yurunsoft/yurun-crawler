<?php
namespace Yurun\Crawler\Module\Crawler\Cron;

use Imi\App;
use Imi\Log\Log;
use Imi\Cron\Contract\ICronTask;
use Yurun\Crawler\Module\Crawler\Contract\ICrawler;

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
        Log::info(sprintf('CrawlerCronTask:id=%s,data=%s', $id, $data));
        /** @var ICrawler $crawler */
        $crawler = App::getBean($id);
        $crawler->run();
    }

}
