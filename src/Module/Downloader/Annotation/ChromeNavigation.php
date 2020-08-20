<?php
namespace Yurun\Crawler\Module\Downloader\Annotation;

use HeadlessChromium\Page;
use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * Chrome 导航注解
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class ChromeNavigation extends Base
{
    /**
     * 等待事件名称
     *
     * @var string
     */
    public $eventName = Page::LOAD;

    /**
     * 超时时间，单位：毫秒，默认 30 秒
     *
     * @var int|null
     */
    public $timeout = 30000;

}
