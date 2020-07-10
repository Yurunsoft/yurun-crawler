<?php
namespace Yurun\Crawler\Module\Parser\Contract;

use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 解析器接口
 */
interface IParser
{
    /**
     * 解析响应数据为数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $modelClass
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|array
     */
    public function parse(ICrawlerItem $crawlerItem, ResponseInterface $response, string $modelClass, $parentInstance = null, bool $isArray = false);

}
