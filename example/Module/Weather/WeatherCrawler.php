<?php
namespace Yurun\CrawlerApp\Module\Weather;

use Imi\Bean\Annotation\Bean;
use Imi\Cron\Consts\CronTaskType;
use Yurun\Crawler\Module\Crawler\Annotation\Crawler;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawler;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerCron;

/**
 * 天气采集爬虫
 * @Bean("WeatherCrawler")
 * @Crawler
 * @CrawlerCron(id="WeatherCrawler", hour="12n", type=CronTaskType::CRON_PROCESS, force=true)
 */
class WeatherCrawler extends BaseCrawler
{
    /**
     * 开始操作，子类中覆盖实现
     *
     * @return void
     */
    protected function __start()
    {
        // 初始下载任务分配
        var_dump('WeatherCrawler start');
    }

}
