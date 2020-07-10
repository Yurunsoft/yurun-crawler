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
