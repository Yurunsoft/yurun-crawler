<?php
namespace Yurun\Crawler\Util;

use Imi\Util\Imi;
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
     * @param bool $isArray
     * @return string
     */
    public static function getPropertyType(string $className, string $propertyName, ?bool &$isArray = false): string
    {
        $property = ReflectionContainer::getPropertyReflection($className, $propertyName);
        if(version_compare(PHP_VERSION, '7.4', '>=') && $property->hasType())
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
                $propertyType = trim($var);
                $isArray = false !== strpos($propertyType, '[]');
                if($isArray)
                {
                    $propertyTypeClass = substr($propertyType, 0, -2);
                }
                else
                {
                    $propertyTypeClass = $propertyType;
                    $isArray = 'array' === $propertyType;
                }
                if(false !== strpos($propertyTypeClass, '\\') && !class_exists($propertyTypeClass))
                {
                    $newClass = str_replace('\\\\', '\\', Imi::getClassNamespace($className) . '\\' . $propertyTypeClass);
                    if(class_exists($newClass))
                    {
                        $propertyTypeClass = $newClass;
                    }
                }
                return $propertyTypeClass;
            }
            else
            {
                $isArray = false;
                return '';
            }
        }
    }

}
