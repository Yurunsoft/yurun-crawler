<?php
namespace Yurun\Crawler\Module\Parser\Annotation;

use Imi\Bean\Annotation\Inherit;

/**
 * JSON 选择
 * @Inherit
 * @Annotation
 * @Target("PROPERTY")
 */
class JsonSelect extends BaseParserAnnotation
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'selector';

    /**
     * 解析器类名
     *
     * @var string
     */
    public $parser = \Yurun\Crawler\Module\Parser\Handler\JsonParser::class;

    /**
     * 选择器，支持多级，如：0.id 即为 $data[0]['id']
     *
     * @var int|string|null
     */
    public $selector;

}
