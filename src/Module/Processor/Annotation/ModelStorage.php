<?php
namespace Yurun\Crawler\Module\Processor\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;
use Imi\Bean\Annotation\Inherit;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;

/**
 * 模型存储
 * @Inherit
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Bean\Parser\NullParser")
 */
class ModelStorage extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected $defaultFieldName = 'model';

    /**
     * 对应的模型类名
     *
     * @var string
     */
    public $model;

    /**
     * 字段映射列表
     * 
     * 将 DataModel 中的 a 赋值给模型类的 b：'a' => 'b'
     *
     * @var array
     */
    public $fields;

    /**
     * 用于判断，重复数据不入库的模型字段
     *
     * @var array
     */
    public $uniqueFields = [];

}
