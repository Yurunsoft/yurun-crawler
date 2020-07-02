<?php
namespace Yurun\Crawler\Module\Parser\Annotation;

use Imi\Bean\Annotation\Inherit;

/**
 * 正则匹配
 * @Inherit
 * @Annotation
 * @Target("PROPERTY")
 */
class RegularMatch extends BaseParserAnnotation
{
    /**
     * 解析器类名
     *
     * @var string
     */
    public $parser = \Yurun\Crawler\Module\Parser\Handler\RegularParser::class;

    /**
     * 选择器
     *
     * @var string
     */
    public $pattern;

    /**
     * 结果序号
     * 
     * 支持数字，也支持多级数组，如：0.1 即为 $matches[0][1]
     *
     * @var int|string|null
     */
    public $index;

}
