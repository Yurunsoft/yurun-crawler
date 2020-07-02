<?php
namespace Yurun\Crawler\Module\Parser\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 解析器注解基类
 * @Parser("Imi\Bean\Parser\NullParser")
 */
abstract class BaseParserAnnotation extends Base
{
    /**
     * 解析器类名
     *
     * @var string
     */
    public $parser;

}
