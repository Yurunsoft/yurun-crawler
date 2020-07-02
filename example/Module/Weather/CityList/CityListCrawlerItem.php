<?php
namespace Yurun\CrawlerApp\Module\Weather\CityList;

use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem;

/**
 * 城市列表采集
 * @CrawlerItem("WeatherCrawler")
 * @Downloader
 * @Parser(\Yurun\CrawlerApp\Module\Weather\CityList\CityListModel::class)
 * @Processor("CityListProcessor")
 */
class CityListCrawlerItem extends BaseCrawlerItem
{

}
