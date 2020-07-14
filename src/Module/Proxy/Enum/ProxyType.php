<?php
namespace Yurun\Crawler\Module\Proxy\Enum;

use Imi\Enum\BaseEnum;
use Imi\Enum\Annotation\EnumItem;

/**
 * 代理类型
 */
abstract class ProxyType extends BaseEnum
{
    /**
     * @EnumItem("HTTP 代理")
     */
    const HTTP = 'http';

    /**
     * @EnumItem("Socks5 代理")
     */
    const SOCKS5 = 'socks5';

}
