<?php
namespace Yurun\Crawler\Test\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Yurun\Crawler\Module\Parser\Annotation\JsonSelect;
use Yurun\Util\YurunHttp\Http\Response;
use Yurun\Crawler\Module\Parser\Handler\JsonParser;
use Yurun\Crawler\Test\Module\YurunBlog\Article\ArticleCrawlerItem;

class JsonParserTest extends TestCase
{
    public function testJsonParserTest()
    {
        $crawlerItem = new ArticleCrawlerItem;
        $parser = new JsonParser;
        $data = [
            'data'  =>  [
                'id'    =>  123,
                'name'  =>  'test',
                'list'  =>  ['a', 'b', 'c'],
            ],
            'code'      =>  0,
            'message'   =>  '',
        ];
        $response = new Response(json_encode($data));

        // selector
        $parserAnnotation = new JsonSelect;
        $parserAnnotation->selector = 'code';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        $this->assertEquals(0, $result);

        // selector.muilti
        $parserAnnotation = new JsonSelect;
        $parserAnnotation->selector = 'data.list.1';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation);
        $this->assertEquals('b', $result);

        // parent
        $parserAnnotation = new JsonSelect;
        $parserAnnotation->selector = 'list';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, $data['data']);
        $this->assertEquals(['a', 'b', 'c'], $result);

        // array
        $parserAnnotation = new JsonSelect;
        $parserAnnotation->selector = '0';
        $result = $parser->parse($crawlerItem, $response, $parserAnnotation, $data['data']['list'], true);
        $this->assertEquals(['a', 'b', 'c'], $result);
    }

}
