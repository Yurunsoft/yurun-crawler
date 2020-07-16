<?php
namespace Yurun\Crawler\Module\Parser\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 日期时间
 * @Annotation
 * @Target("PROPERTY")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class DateTime extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'format';

    /**
     * 转换格式，同 date() 参数
     *
     * @var string
     */
    public $format = 'Y-m-d H:i:s';

}
