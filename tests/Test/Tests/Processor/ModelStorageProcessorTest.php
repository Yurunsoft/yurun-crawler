<?php
namespace Yurun\Crawler\Test\Tests\Processor;

use Imi\App;
use PHPUnit\Framework\TestCase;
use Yurun\Crawler\Module\Processor\Handler\ModelStorageProcessor;
use Yurun\Crawler\Test\Module\YurunBlog\Article\Model\ArticleModel;
use Yurun\Crawler\Test\Module\YurunBlog\Model\Article;

class ModelStorageProcessorTest extends TestCase
{
    public function testModelStorageProcessor()
    {
        $this->assertEquals(0, Article::dbQuery()->whereEx(['title' => 'test'])->count());
        /** @var \Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem $crawlerItem */
        $crawlerItem = App::getBean('ArticleCrawlerItem');
        $data = new ArticleModel;
        $data->title = 'test';
        $modelStorageProcessor = new ModelStorageProcessor;
        $modelStorageProcessor->process($crawlerItem, $data);
        $this->assertEquals(1, Article::dbQuery()->whereEx(['title' => 'test'])->count());

        $modelStorageProcessor->process($crawlerItem, $data);
        $this->assertEquals(1, Article::dbQuery()->whereEx(['title' => 'test'])->count());
    }

}
