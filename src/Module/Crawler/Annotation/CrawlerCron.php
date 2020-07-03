<?php
namespace Yurun\Crawler\Module\Crawler\Annotation;

use Imi\Bean\Annotation\Parser;

/**
 * 采集定时任务注解
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class CrawlerCron extends \Imi\Cron\Annotation\Cron
{

}
