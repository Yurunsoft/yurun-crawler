<?php
namespace Yurun\Crawler\Test\Module\YurunBlog\ArticleList;

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
 * @Downloader(limit=3)
 * @Parser(\Yurun\Crawler\Test\Module\YurunBlog\ArticleList\Model\ArticleListModel::class)
 * @Processor("ArticleListProcessor")
 */
class ArticleListCrawlerItem extends BaseCrawlerItem
{
    
}
