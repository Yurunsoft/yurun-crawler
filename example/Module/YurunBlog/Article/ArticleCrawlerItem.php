<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article;

use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem;
use Yurun\Crawler\Module\Processor\Annotation\ModelStorage;

/**
 * 文章内容采集
 * @Bean("ArticleCrawlerItem")
 * @CrawlerItem("YurunBlogCrawler")
 * @Downloader(limit=3)
 * @Parser(\Yurun\CrawlerApp\Module\YurunBlog\Article\Model\ArticleModel::class)
 * @Processor({"ArticleProcessor", "ModelStorageProcessor"})
 * @ModelStorage(model=\Yurun\CrawlerApp\Module\YurunBlog\Model\Article::class, uniqueFields={"title"})
 */
class ArticleCrawlerItem extends BaseCrawlerItem
{
    
}
