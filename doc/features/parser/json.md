# JSON

JSON 选择，超简单，没啥好说的

## 示例

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\Article\Model;

use Yurun\Crawler\Module\Parser\Annotation\JsonSelect;
use Yurun\Crawler\Module\DataModel\Contract\BaseDataModel;

/**
 * 文章内容模型
 */
class ArticleModel extends BaseDataModel
{
    /**
     * 标题
     * 
     * @JsonSelect(selector="data.title")
     *
     * @var string
     */
    public $title;

}
```

## 注解

### @JsonSelect

类名：`\Yurun\Crawler\Module\Parser\Annotation\JsonSelect`

**参数：**

名称 | 描述 | 默认值
-|-|-
selector|选择器，支持多级，如：0.id 即为 $data[0]['id']|

> 如果`selector`为`null`，则将匹配结果全部赋值给属性。
