# Dom 解析

支持 jQuery 语法解析 dom，基于 `symfony/dom-crawler`、`symfony/css-selector` 实现。

## 示例

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article\Model;

use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;
use Yurun\Crawler\Module\DataModel\Contract\BaseDataModel;

/**
 * 文章内容模型
 */
class ArticleModel extends BaseDataModel
{
    /**
     * 标题
     * 
     * @DomSelect(selector=".article-view h1", method=DomSelectMethod::TEXT)
     *
     * @var string
     */
    public $title;

    /**
     * 内容
     *
     * @DomSelect(selector=".article-content", method=DomSelectMethod::HTML)
     * 
     * @var string
     */
    public $content;

    /**
     * 时间
     *
     * @DomSelect(selector=".article-info .time", method=DomSelectMethod::TEXT)
     *
     * @var string
     */
    public $time;

}
```

## 注解

### @DomSelect

Dom 选择

类名：`\Yurun\Crawler\Module\Parser\Annotation\DomSelect`

**参数：**

名称 | 描述 | 默认值
-|-|-
selector|选择器|
method|获取数据的方法，支持`attr`、`count`、`outerHtml`、`html`、`text`等|
param|获取数据的方法传参|

> 如果当前属性是一个模型，可以将`method`设为`null`，然后这个模型就会直接从当前匹配的节点，开始查找节点。
