# 爬虫项

爬虫项是什么呢？比如采集文章列表、文章详情页，他们都是不同的采集项。

**定义示例：**

继承`Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem`类。

```php
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
```

**前置和后置方法：**

每一步动作前后置方法，你都可以介入。覆盖方法即可。

支持覆盖的方法如下：

```php
/**
 * 下载内容前置操作
 *
 * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
 * @return \Psr\Http\Message\ResponseInterface|null
 */
protected function beforeDownload(DownloadParams $params): ?ResponseInterface
{
    return null;
}

/**
 * 下载内容后置操作
 *
 * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
 * @return \Psr\Http\Message\ResponseInterface
 */
protected function afterDownload(DownloadParams $params, ResponseInterface $response): ResponseInterface
{
    return $response;
}

/**
 * 解析前置操作
 *
 * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
 * @param string $modelClass
 * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
 */
protected function beforeParse(ParserParams $params, string $modelClass): ?IDataModel
{
    return null;
}

/**
 * 解析后置操作
 *
 * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
 * @param string $modelClass
 * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
 * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
 */
protected function afterParse(ParserParams $params, string $modelClass, IDataModel $data): IDataModel
{
    return $data;
}

/**
 * 处理前置操作
 *
 * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
 * @return void
 */
protected function beforeProcess(ProcessorParams $params)
{

}

/**
 * 处理后置操作
 *
 * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
 * @return void
 */
protected function afterProcess(ProcessorParams $params)
{

}
```

## 注解

### @CrawlerItem

类名：`\Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem`

爬虫项定义，必须

`@CrawlerItem("YurunBlogCrawler")`

**参数：**

名称 | 描述 | 默认值
-|-|-
class|爬虫对象类名|

### @Downloader

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Downloader`

声明下载器，非必须，缺省则取爬虫对象上的

**参数：**

名称 | 描述 | 默认值
-|-|-
class|下载器类名|`Yurun\Crawler\Module\Downloader\Handler\YurunHttpDownloader`
queue|下载器队列名|defaultDownloader
limit|限流数量，小于等于0时不限制|`null`
limitUnit|限流单位时间，默认为：秒(second)；支持：microsecond、millisecond、second、minute、hour、day、week、month、year|`limitUnit`
limitWait|限流等待时间，单位：秒|60

### @Parser

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Parser`

声明解析器，必须

**参数：**

名称 | 描述 | 默认值
-|-|-
model|模型类名|
queue|解析器队列名|defaultParser

### @Processor

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Processor`

声明处理器，必须

**参数：**

名称 | 描述 | 默认值
-|-|-
class|处理器类名或类名数组|
queue|处理器队列名|defaultProcessor
