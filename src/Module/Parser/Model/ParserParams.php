<?php
namespace Yurun\Crawler\Module\Parser\Model;

/**
 * 解析器参数
 */
class ParserParams
{
    /**
     * 响应体
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    public $response;

    /**
     * 数据
     *
     * @var array
     */
    public $data;

}
