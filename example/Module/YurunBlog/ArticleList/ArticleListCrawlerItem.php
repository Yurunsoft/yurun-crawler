<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\ArticleList;

use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem;

/**
 * 文章列表采集
 * @Bean("ArticleListCrawlerItem")
 * @CrawlerItem("YurunBlogCrawler")
 * @Downloader
 * @Parser(\Yurun\CrawlerApp\Module\YurunBlog\ArticleList\Model\ArticleListModel::class)
 * @Processor("ArticleListProcessor")
 */
class ArticleListCrawlerItem extends BaseCrawlerItem
{
    
}
