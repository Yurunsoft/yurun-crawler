<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Base;

/**
 * 声明解析器
 * @Annotation
 * @Target("CLASS")
 * @\Imi\Bean\Annotation\Parser("Imi\Bean\Parser\NullParser")
 */
class Parser extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'model';

    /**
     * 模型类名
     *
     * @var string
     */
    public $model;

}
