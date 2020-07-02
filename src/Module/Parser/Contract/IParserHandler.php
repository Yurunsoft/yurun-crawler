<?php
namespace Yurun\Crawler\Module\Parser\Contract;

use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * 解析器接口
 */
interface IParserHandler
{
    /**
     * 解析响应数据为数据模型
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parse(ResponseInterface $response, BaseParserAnnotation $parserAnnotation, $parentInstance = null, bool $isArray = false);

}
