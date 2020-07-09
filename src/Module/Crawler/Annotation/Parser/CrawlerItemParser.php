<?php
namespace Yurun\Crawler\Module\Crawler\Annotation\Parser;

use Imi\Bean\Parser\BaseParser;

class CrawlerItemParser extends BaseParser
{
    /**
     * 处理方法
     * @param \Imi\Bean\Annotation\Base $annotation 注解类
     * @param string $className 类名
     * @param string $target 注解目标类型（类/属性/方法）
     * @param string $targetName 注解目标名称
     * @return void
     */
    public function parse(\Imi\Bean\Annotation\Base $annotation, string $className, string $target, string $targetName)
    {
        /** @var \Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem $annotation */
        $this->data[$annotation->class][] = [
            'className'             =>  $className,
            'crawlerItemAnnotation' =>  $annotation,
        ];
    }
}
