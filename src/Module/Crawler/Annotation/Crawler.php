<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 采集爬虫定义
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class Crawler extends Base
{
    /**
     * 等待上一次运行爬取任务执行完成后，才可以进行下一次
     *
     * @var boolean
     */
    public $waitComplete = false;

}
