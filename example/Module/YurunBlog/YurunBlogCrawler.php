<?php
namespace Yurun\CrawlerApp\Module\YurunBlog;

use Imi\Bean\Annotation\Bean;
use Imi\Cron\Consts\CronTaskType;
use Imi\Log\Log;
use Yurun\Crawler\Module\Crawler\Annotation\Crawler;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawler;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerCron;

/**
 * 宇润博客采集爬虫
 * @Bean("YurunBlogCrawler")
 * @Crawler(waitComplete=true)
 * @CrawlerCron(hour="12n", force=true)
 */
class YurunBlogCrawler extends BaseCrawler
{
    /**
     * 开始操作，一般做一些初始化操作
     * 
     * 子类中覆盖实现
     *
     * @return void
     */
    protected function __start()
    {
        // 初始下载任务分配
        Log::info('YurunBlogCrawler start');
    }

    /**
     * 运行爬取任务
     * 
     * 子类中覆盖实现
     *
     * @return void
     */
    protected function __run()
    {
        Log::info('YurunBlogCrawler run');
        $this->pushDownloadMessage('ArticleListCrawlerItem', 'https://blog.yurunsoft.com/');
        Log::info('pushed');
    }

}
