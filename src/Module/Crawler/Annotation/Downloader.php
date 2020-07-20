<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;
use Yurun\Crawler\Module\Downloader\Handler\YurunHttpDownloader;

/**
 * 声明下载器
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class Downloader extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'class';

    /**
     * 下载器类名
     *
     * @var string
     */
    public $class = YurunHttpDownloader::class;

    /**
     * 下载器队列名
     *
     * @var string
     */
    public $queue = 'defaultDownloader';

    /**
     * 限流数量
     * 
     * 小于等于0时不限制
     *
     * @var integer
     */
    public $limit;

    /**
     * 限流单位时间，默认为：秒(second)
     * 
     * 支持：microsecond、millisecond、second、minute、hour、day、week、month、year
     *
     * @var string
     */
    public $limitUnit = 'second';

    /**
     * 限流等待时间，单位：秒
     *
     * @var int
     */
    public $limitWait = 60;

    /**
     * 单个工作超时时间，单位：秒
     *
     * @var float
     */
    public $timeout = 60;

}
