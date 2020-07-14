<?php
namespace Yurun\Crawler\Test\Tests\Downloader;

use PHPUnit\Framework\TestCase;
use Yurun\Util\YurunHttp\Http\Psr7\ServerRequest;
use Yurun\Crawler\Module\Downloader\Handler\YurunHttpDownloader;
use Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem;

class YurunHttpDownloaderTest extends TestCase
{
    public function testYurunHttpDownloader()
    {
        $downloader = new YurunHttpDownloader;
        $crawlerItem = new ArticleCrawlerItem;
        $request = new ServerRequest('https://httpbin.org/get?id=1');
        $response = $downloader->download($crawlerItem, $request);
        $this->assertEquals([
            'id'    =>  '1',
        ], json_decode($response->getBody(), true)['args'] ?? null);
    }

}
