<?php
namespace Yurun\Crawler\Test\Module\YurunBlog\Article;

use Imi\App;
use Imi\Log\Log;
use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Processor\Contract\IProcessor;

/**
 * 文章内容处理器
 * @Bean("ArticleProcessor")
 */
class ArticleProcessor implements IProcessor
{
    /**
     * 处理数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Yurun\Crawler\Test\Module\YurunBlog\Article\Model\ArticleModel $data
     * @return void
     */
    public function process(ICrawlerItem $crawlerItem, IDataModel $data)
    {
        // var_dump($data);
        // Log::info('Article count:' . count($data->list));
        // Log::info('next:' . $data->nextUrl);
        // /** @var \Yurun\Crawler\Test\Module\YurunBlog\YurunBlogCrawler $yurunBlogCrawler */
        // $yurunBlogCrawler = App::getBean('YurunBlogCrawler');
        // if($data->nextUrl)
        // {
        //     $url = $data->nextUrl;
        //     if('//' === substr($url, 0, 2))
        //     {
        //         $url = 'https:' . $url;
        //     }
        //     $yurunBlogCrawler->pushDownloadMessage('ArticleListCrawlerItem', $url);
        // }
        // throw new \RuntimeException('GG');
        var_dump($data->title);
    }

}
