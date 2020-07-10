<?php
namespace Yurun\Crawler\Module\Crawler\Enum;

use Imi\Enum\BaseEnum;
use Imi\Enum\Annotation\EnumItem;

/**
 * 队列消息类型
 */
abstract class QueueMessageType extends BaseEnum
{
    /**
     * @EnumItem("下载器")
     */
    const DOWNLOADER = 'downloader';

    /**
     * @EnumItem("解析器")
     */
    const PARSER = 'parser';

    /**
     * @EnumItem("处理器")
     */
    const PROCESSOR = 'processor';

}
