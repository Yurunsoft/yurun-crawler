<?php
namespace Yurun\Crawler\Test\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;
use Yurun\Crawler\Module\Parser\Handler\DomParser;
use Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem;
use Yurun\Util\YurunHttp\Http\Response;

class DomParserTest extends TestCase
{
    public function testDomParser()
    {
        $crawlerItem = new ArticleCrawlerItem;
        $parser = new DomParser;
        $response = new Response(<<<HTML
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
        <title>test</title>
    </head>
	<body>
        <ul id="ul1">
            <li data-id="1"><b>a</b></li>
            <li data-id="2"><b>b</b></li>
            <li data-id="3"><b>c</b></li>
        </ul>
    </body>
</html>
HTML
        );

        // selector
        $parserAnnotation = new DomSelect;
        $parserAnnotation->selector = '#ul1';
        $parserAnnotation->method = null;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        /** @var \Symfony\Component\DomCrawler\Crawler $result */
        $this->assertInstanceOf(\Symfony\Component\DomCrawler\Crawler::class, $result);
        $this->assertEquals('ul', $result->nodeName());

        // parentInstance
        $parserAnnotation = new DomSelect;
        $parserAnnotation->selector = 'li';
        $parserAnnotation->method = null;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, $result);
        /** @var \Symfony\Component\DomCrawler\Crawler $result */
        $this->assertInstanceOf(\Symfony\Component\DomCrawler\Crawler::class, $result);
        $this->assertEquals(3, $result->count());

        // method
        $parserAnnotation = new DomSelect;
        $parserAnnotation->selector = '#ul1';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        $this->assertEquals(<<<HTML
<li data-id="1"><b>a</b></li>
            <li data-id="2"><b>b</b></li>
            <li data-id="3"><b>c</b></li>
HTML
        , trim($result));

        // param
        $parserAnnotation = new DomSelect;
        $parserAnnotation->selector = '#ul1 li:nth-child(2)';
        $parserAnnotation->method = DomSelectMethod::ATTR;
        $parserAnnotation->param = 'data-id';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        $this->assertEquals('2', $result);

        // param and text
        $parserAnnotation = new DomSelect;
        $parserAnnotation->selector = '#ul1 li';
        $parserAnnotation->method = DomSelectMethod::TEXT;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, null, true);
        $this->assertEquals(['a', 'b', 'c'], $result);
    }

}
