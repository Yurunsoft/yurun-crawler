<?php
namespace Yurun\Crawler\Test\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Yurun\Util\YurunHttp\Http\Response;
use Yurun\Crawler\Module\Parser\Handler\RegularParser;
use Yurun\Crawler\Module\Parser\Annotation\RegularMatch;
use Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem;

class RegularParserTest extends TestCase
{
    public function testJsonParserTest()
    {
        $crawlerItem = new ArticleCrawlerItem;
        $parser = new RegularParser;
        $response = new Response(<<<STR
1-宇润-19940312
2-他-19260817
3-imi-20180621
STR
        );

        // selector
        $parserAnnotation = new RegularMatch;
        $parserAnnotation->pattern = '/(\d+)-([^-]+)-(\d{8})/';
        $parserAnnotation->index = 2;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        $this->assertEquals('宇润', $result);

        // parentInstance
        $parserAnnotation = new RegularMatch;
        $parserAnnotation->pattern = '/(\d+)-([^-]+)-(\d{8})/';
        $parserAnnotation->index = 2;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, '2-他-19260817');
        $this->assertEquals('他', $result);

        // selector + array
        $parserAnnotation = new RegularMatch;
        $parserAnnotation->pattern = '/(\d+)-([^-]+)-(\d{8})/';
        $parserAnnotation->index = 3;
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, null, true);
        $this->assertEquals([
            '19940312',
            '19260817',
            '20180621',
        ], $result);
    }

}
