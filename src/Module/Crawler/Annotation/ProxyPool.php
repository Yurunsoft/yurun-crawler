<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 声明代理 IP 池
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class ProxyPool extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'class';

    /**
     * 代理 IP 池名
     *
     * @var string
     */
    public $class;

    /**
     * 实例化参数
     *
     * @var array
     */
    public $args = [];

    /**
     * 获取 IP 的方式
     *
     * @var string
     */
    public $method = 'random';

}
