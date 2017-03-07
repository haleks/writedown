<?php

use Haleks\Writedown\Parsers\CommonMarkParser;

class CommonMarkParserTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    /** @test */
    public function it_can_insert_markdown_to_the_content_property()
    {
        $parser = new CommonMarkParser($this->mockCommonMark());

        $parser->content('# title');
        $expected = '# title';

        $this->assertAttributeEquals($expected, 'content', $parser);
    }

    /** @test */
    public function it_can_insert_markdown_to_the_content_property_and_return_itself()
    {
        $parser = new CommonMarkParser($this->mockCommonMark());

        $actual = $parser->content('# title');
        $expected = CommonMarkParser::class;

        $this->assertInstanceOf($expected, $actual);
    }

    /** @test */
    public function it_can_parse_content_into_html()
    {
        $parser = new CommonMarkParser($commonmark = $this->mockCommonMark());

        $commonmark->shouldReceive('convertToHtml')->with('# title')->andReturn('<h1>title</h1>');

        $actual = $parser->content('# title')->toHtml();
        $expected = '<h1>title</h1>';

        $this->assertSame($expected, $actual);
    }

    public function mockCommonMark()
    {
        return Mockery::mock(\League\CommonMark\CommonMarkConverter::class);
    }
}
