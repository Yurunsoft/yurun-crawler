<?php
namespace Yurun\Crawler\Module\Crawler\Service;

use Imi\App;
use Imi\Bean\Annotation\AnnotationManager;
use Imi\Bean\Annotation\Bean;
use Imi\Bean\BeanFactory;
use Yurun\Crawler\Module\Crawler\Contract\ICrawler;

/**
 * 爬虫管理器
 * @Bean("CrawlerManager")
 */
class CrawlerManager
{
    /**
     * 获取爬虫对象
     *
     * @param string $name
     * @return \Yurun\Crawler\Module\Crawler\Contract\ICrawler
     */
    public function getBean(string $name): ICrawler
    {
        $object = App::getBean($name);
        $className = BeanFactory::getObjectClass($object);
        $crawlerAnnotation = AnnotationManager::getClassAnnotations($className, \Yurun\Crawler\Module\Crawler\Annotation\Crawler::class)[0];
        if(!$crawlerAnnotation)
        {
            throw new \InvalidArgumentException(sprintf('Bean %s does not a Crawler class'));
        }
        return $object;
    }

    /**
     * 获取所有爬虫名称或类名
     *
     * @return string[]
     */
    public function getAllNames(): array
    {
        $result = [];
        foreach(AnnotationManager::getAnnotationPoints(\Yurun\Crawler\Module\Crawler\Annotation\Crawler::class, 'class') as $point)
        {
            $className = $point->getClass();
            /** @var \Imi\Bean\Annotation\Bean $bean */
            $bean = AnnotationManager::getClassAnnotations($className, \Imi\Bean\Annotation\Bean::class)[0];
            if($bean)
            {
                $result[] = $bean->name;
            }
            else
            {
                $result[] = $className;
            }
        }
        return $result;
    }

}
