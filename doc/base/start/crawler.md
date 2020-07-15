# 开始编写采集——爬虫对象类

一个爬虫对象下面可能会有多个爬虫项目，他们都是相关联的。

**定义示例：**

继承`Yurun\Crawler\Module\Crawler\Contract\BaseCrawler`类，并实现方法。

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

### @Bean

类名：`\Imi\Bean\Annotation\Bean`

定义当前类的别名，非必须，建议定义。

`@Bean("YurunBlogCrawler")`

### @Crawler

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Crawler`

定义当前类为爬虫对象，必须！

**参数：**

名称 | 描述 | 默认值
-|-|-
waitComplete|等待上一次运行爬取任务执行完成后，才可以进行下一次|`false`

### @Downloader

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Downloader`

为这个爬虫对象下所有爬虫项目设置一个缺省的下载器

**参数：**

名称 | 描述 | 默认值
-|-|-
class|下载器类名|`Yurun\Crawler\Module\Downloader\Handler\YurunHttpDownloader`
queue|下载器队列名|defaultDownloader
limit|限流数量，小于等于0时不限制|`null`
limitUnit|限流单位时间，默认为：秒(second)；支持：microsecond、millisecond、second、minute、hour、day、week、month、year|`limitUnit`
limitWait|限流等待时间，单位：秒|60
