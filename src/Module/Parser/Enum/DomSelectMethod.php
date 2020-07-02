<?php
namespace Yurun\Crawler\Module\Parser\Enum;

use Imi\Enum\BaseEnum;
use Imi\Enum\Annotation\EnumItem;

abstract class DomSelectMethod extends BaseEnum
{
    /**
     * @EnumItem("属性")
     */
    const ATTR = 'attr';

    /**
     * @EnumItem("元素数量")
     */
    const COUNT = 'count';

    /**
     * @EnumItem("外层 html")
     */
    const OUTER_HTML = 'outerHtml';

    /**
     * @EnumItem("html")
     */
    const HTML = 'html';

    /**
     * @EnumItem("纯文本")
     */
    const TEXT = 'text';

}
