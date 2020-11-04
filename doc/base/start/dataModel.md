# 数据模型

数据模型用于存放，通过页面、JSON 等途径解析出来的数据。

可以在模型属性上使用注解，将数据解析到属性上。

支持模型嵌套、属性数组。

继承 `Yurun\Crawler\Module\DataModel\Contract\BaseDataModel` 类。

## 示例

**ArticleListItemModel.php：**

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\ArticleList\Model;

use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;
use Yurun\Crawler\Module\DataModel\Contract\BaseDataModel;

/**
 * 文章列表项模型
 */
class ArticleListItemModel extends BaseDataModel
{
    /**
     * 文章地址
     * 
     * @DomSelect(selector="h2 a", method=DomSelectMethod::ATTR, param="href")
     *
     * @var string
     */
    public $url;

}
```

**ArticleListModel.php：**

```php
<?php
namespace Yurun\CrawlerApp\Module\YurunBlog\ArticleList\Model;

use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;
use Yurun\Crawler\Module\DataModel\Contract\BaseDataModel;

/**
 * 文章列表模型
 */
class ArticleListModel extends BaseDataModel
{
    /**
     * 文章列表
     * 
     * @DomSelect(selector="#left-box ul.article-list-img-text > li", method=null)
     *
     * @var ArticleListItemModel[]
     */
    public $list;

    /**
     * 下一页地址
     * 
     * @DomSelect(selector="#Pagebar1 .next", method=DomSelectMethod::ATTR, param="href")
     *
     * @var string
     */
    public $nextUrl;

}
```

## 注解

详见解析器章节：<a href="../../features/parser/dom.html">链接</a>
