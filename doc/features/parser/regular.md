# 正则

正则匹配，如果是单个则模式是使用的`PREG_SET_ORDER`。

## 示例

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article\Model;

use Yurun\Crawler\Module\Parser\Annotation\RegularMatch;
use Yurun\Crawler\Module\DataModel\Contract\BaseDataModel;

/**
 * 文章内容模型
 */
class ArticleModel extends BaseDataModel
{
    /**
     * 标题
     * 
     * @RegularMatch(pattern="/(\w+)/", index="1")
     *
     * @var string
     */
    public $title;

}
```

## 注解

### @RegularMatch

类名：`\Yurun\Crawler\Module\Parser\Annotation\RegularMatch`

**参数：**

名称 | 描述 | 默认值
-|-|-
pattern|选择器|
index|结果序号，支持数字，也支持多级数组，如：0.1 即为 $matches[0][1]|

> 如果`index`为`null`，则将匹配结果全部赋值给属性。
