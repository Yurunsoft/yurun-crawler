<?php
namespace Yurun\Crawler\Module\Parser\Annotation;

use Imi\Bean\Annotation\Inherit;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;

/**
 * Dom 选择
 * @Inherit
 * @Annotation
 * @Target("PROPERTY")
 */
class DomSelect extends BaseParserAnnotation
{
    /**
     * 解析器类名
     *
     * @var string
     */
    public $parser = \Yurun\Crawler\Module\Parser\Handler\DomParser::class;

    /**
     * 选择器
     *
     * @var string
     */
    public $selector;

    /**
     * 获取数据的方法
     *
     * @var string
     */
    public $method = DomSelectMethod::HTML;

    /**
     * 获取数据的方法传参
     *
     * @var mixed|array
     */
    public $param;

}
