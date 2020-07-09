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

}
