# 处理器

数据解析为模型后，下面的任务就是交给处理器做处理。

当然你也可以不编写处理器，使用内置的处理器。

## 示例

实现`Yurun\Crawler\Module\Processor\Contract\IProcessor`接口

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article;

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
     * @param \Yurun\CrawlerApp\Module\YurunBlog\Article\Model\ArticleModel $data
     * @return void
     */
    public function process(ICrawlerItem $crawlerItem, IDataModel $data)
    {
        var_dump($data->title);
    }

}
```

## 内置处理器

<a href="../../features/modelStorage.html">模型存储处理器</a>
