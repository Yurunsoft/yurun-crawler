<?php
namespace Yurun\Crawler\Util;

use Imi\Bean\ReflectionContainer;
use phpDocumentor\Reflection\DocBlockFactory;

abstract class DocBlockUtil
{
    /**
     * @var \phpDocumentor\Reflection\DocBlockFactory
     */
    private static $docBlockFactory;

    /**
     * 获取 DocBlockFactory 单例
     *
     * @return \phpDocumentor\Reflection\DocBlockFactory
     */
    public static function getDocBlockFactory(): DocBlockFactory
    {
        if(static::$docBlockFactory)
        {
            return static::$docBlockFactory;
        }
        else
        {
            return static::$docBlockFactory = DocBlockFactory::createInstance();
        }
    }

    /**
     * 获取类属性类型
     *
     * @param string $className
     * @param string $propertyName
     * @return string
     */
    public static function getPropertyType(string $className, string $propertyName): string
    {
        $property = ReflectionContainer::getPropertyReflection($className, $propertyName);
        if($property->hasType())
        {
            return $property->getType();
        }
        else
        {
            $factory = static::getDocBlockFactory();
            $docblock = $factory->create($property->getDocComment());
            $var = $docblock->getTagsByName('var')[0] ?? null;
            if($var)
            {
                return trim($var);
            }
            else
            {
                return '';
            }
        }
    }

}
