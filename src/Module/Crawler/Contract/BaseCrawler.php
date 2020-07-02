<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Imi\Bean\BeanFactory;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;

/**
 * 爬虫基类
 */
abstract class BaseCrawler implements ICrawler
{
    /**
     * 开始爬取
     *
     * @return void
     */
    public function start()
    {
        $this->__start();
    }

    /**
     * 开始操作，子类中覆盖实现
     *
     * @return void
     */
    protected abstract function __start();

    /**
     * 获取下载器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Downloader
     */
    public function getDownloaderAnnotation(): Downloader
    {
        $class = BeanFactory::getObjectClass($this);
        $downloader = AnnotationManager::getClassAnnotations($class, Downloader::class)[0] ?? null;
        if(null === $downloader)
        {
            $downloader = new Downloader;
        }
        return $downloader;
    }

}
