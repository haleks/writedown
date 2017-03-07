<?php

use Haleks\Writedown\Parsers\MarkdownParser;

class MarkdownParserTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    /** @test */
    public function it_can_insert_markdown_to_the_content_property()
    {
        $parser = new MarkdownParser($this->mockMarkdown());

        $parser->content('# title');
        $expected = '# title';

        $this->assertAttributeEquals($expected, 'content', $parser);
    }

    /** @test */
    public function it_can_insert_markdown_to_the_content_property_and_return_itself()
    {
        $parser = new MarkdownParser($this->mockMarkdown());

        $actual = $parser->content('# title');
        $expected = MarkdownParser::class;

        $this->assertInstanceOf($expected, $actual);
    }

    /** @test */
    public function it_can_parse_content_into_html()
    {
        $parser = new MarkdownParser($markdown = $this->mockMarkdown());

        $markdown->shouldReceive('transform')->with('# title')->andReturn('<h1>title</h1>');

        $actual = $parser->content('# title')->toHtml();
        $expected = '<h1>title</h1>';

        $this->assertSame($expected, $actual);
    }

    public function mockMarkdown()
    {
        return Mockery::mock(\Michelf\Markdown::class);
    }
}
