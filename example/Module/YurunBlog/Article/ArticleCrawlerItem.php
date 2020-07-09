<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article;

use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem;

/**
 * 文章内容采集
 * @Bean("ArticleCrawlerItem")
 * @CrawlerItem("YurunBlogCrawler")
 * @Downloader
 * @Parser(\Yurun\CrawlerApp\Module\YurunBlog\Article\Model\ArticleModel::class)
 * @Processor("ArticleProcessor")
 */
class ArticleCrawlerItem extends BaseCrawlerItem
{
    
}
