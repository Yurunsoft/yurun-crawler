<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\ArticleList;

use Imi\App;
use Imi\Log\Log;
use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Processor\Contract\IProcessor;

/**
 * 文章列表处理器
 * @Bean("ArticleListProcessor")
 */
class ArticleListProcessor implements IProcessor
{
    /**
     * 处理数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Yurun\CrawlerApp\Module\YurunBlog\ArticleList\Model\ArticleListModel $data
     * @return void
     */
    public function process(ICrawlerItem $crawlerItem, IDataModel $data)
    {
        Log::info('Article count:' . count($data->list));
        Log::info('next:' . $data->nextUrl);
        /** @var \Yurun\CrawlerApp\Module\YurunBlog\YurunBlogCrawler $yurunBlogCrawler */
        $yurunBlogCrawler = App::getBean('YurunBlogCrawler');
        // 文章内容
        foreach($data->list as $item)
        {
            $url = $item->url;
            if('//' === substr($url, 0, 2))
            {
                $url = 'https:' . $url;
            }
            $yurunBlogCrawler->pushDownloadMessage('ArticleCrawlerItem', $url);
        }
        // 下一页
        if($data->nextUrl)
        {
            $url = $data->nextUrl;
            if('//' === substr($url, 0, 2))
            {
                $url = 'https:' . $url;
            }
            $yurunBlogCrawler->pushDownloadMessage('ArticleListCrawlerItem', $url);
        }
    }

}
