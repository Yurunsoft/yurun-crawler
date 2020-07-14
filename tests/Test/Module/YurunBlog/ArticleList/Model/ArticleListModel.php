<?php
namespace Yurun\Crawler\Test\Module\YurunBlog\ArticleList\Model;

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
