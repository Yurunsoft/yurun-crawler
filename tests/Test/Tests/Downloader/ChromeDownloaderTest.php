<?php
namespace Yurun\Crawler\Test\Tests\Downloader;

use PHPUnit\Framework\TestCase;
use Yurun\Util\YurunHttp\Http\Psr7\ServerRequest;
use Yurun\Crawler\Module\Downloader\Handler\ChromeDownloader;
use Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem;

class ChromeDownloaderTest extends TestCase
{
    public function testChromeDownloader()
    {
        $downloader = new ChromeDownloader;
        $downloader->setPath(getenv('CHROME_HEADLESS_PATH'));
        $downloader->setOptions([
            'noSandbox'  =>  true,
        ]);
        $crawlerItem = new ArticleCrawlerItem;
        $request = new ServerRequest('https://httpbin.org/html');
        $response = $downloader->download($crawlerItem, $request);
        $body = $response->getBody()->getContents();
        $this->assertNotFalse(strpos($body, 'Herman Melville - Moby-Dick'));
    }

}
