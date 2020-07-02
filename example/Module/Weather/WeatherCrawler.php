<?php
namespace Yurun\CrawlerApp\Module\Weather;

use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawler;

/**
 * 天气采集爬虫
 * @Bean("WeatherCrawler")
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

    }

}
