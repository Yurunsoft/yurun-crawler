<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 声明处理器
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class Processor extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'class';

    /**
     * 处理器类名或类名数组
     *
     * @var string|string
     */
    public $class;

    /**
     * 处理器队列名
     *
     * @var string
     */
    public $queue = 'defaultProcessor';

    /**
     * 单个工作超时时间，单位：秒
     *
     * @var float
     */
    public $timeout = 60;

}
