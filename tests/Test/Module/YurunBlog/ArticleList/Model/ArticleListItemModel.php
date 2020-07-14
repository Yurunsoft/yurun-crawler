<?php
namespace Yurun\Crawler\Test\Module\YurunBlog\ArticleList\Model;

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
