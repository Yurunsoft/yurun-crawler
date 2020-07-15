# 定时采集

通过注解实现，写在爬虫对象类上

**示例：**

```php
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
        // 这里一般做运行任务时候，推下载消息
        Log::info('YurunBlogCrawler run');
        $this->pushDownloadMessage('ArticleListCrawlerItem', 'https://blog.yurunsoft.com/');
        Log::info('pushed');
    }

}
```

## 注解

### @CrawlerCron

类名：`\Yurun\Crawler\Module\Crawler\Annotation\CrawlerCron`

采集定时任务注解，非必须。

参数：

同 imi 框架的 `@Cron` 注解：<https://doc.imiphp.com/components/task/cron.html>
