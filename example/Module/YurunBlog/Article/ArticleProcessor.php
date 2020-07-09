<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article;

use Imi\App;
use Imi\Bean\Annotation\Bean;
use Imi\Log\Log;
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
     * @param \Yurun\CrawlerApp\Module\YurunBlog\ArticleList\Model\ArticleListModel $data
     * @return void
     */
    public function process(IDataModel $data)
    {
        // var_dump($data);
        // Log::info('Article count:' . count($data->list));
        // Log::info('next:' . $data->nextUrl);
        // /** @var \Yurun\CrawlerApp\Module\YurunBlog\YurunBlogCrawler $yurunBlogCrawler */
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
        throw new \RuntimeException('GG');
    }

}
