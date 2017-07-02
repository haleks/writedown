<?php

use Haleks\Writedown\Parsers\ParsedownParser;

class ParsedownParserTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    /** @test */
    public function it_can_insert_markdown_to_the_content_property()
    {
        $parser = new ParsedownParser($this->mockParsedown());

        $parser->content('# title');
        $expected = '# title';

        $this->assertAttributeEquals($expected, 'content', $parser);
    }

    /** @test */
    public function it_can_insert_markdown_to_the_content_property_and_return_itself()
    {
        $parser = new ParsedownParser($this->mockParsedown());

        $actual = $parser->content('# title');
        $expected = ParsedownParser::class;

        $this->assertInstanceOf($expected, $actual);
    }

    /** @test */
    public function it_can_parse_content_into_html()
    {
        $parser = new ParsedownParser($parsedown = $this->mockParsedown());

        $parsedown->shouldReceive('text')->with('# title')->andReturn('<h1>title</h1>');

        $actual = $parser->content('# title')->toHtml();
        $expected = '<h1>title</h1>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_parse_markdown_extra_content_into_html()
    {
        $parser = new ParsedownParser($parsedown = $this->mockParsedownExtra());

        $parsedown->shouldReceive('text')->with('# title {#id .class}')->andReturn('<h1 id ="id" class="class">title</h1>');

        $actual = $parser->content('# title {#id .class}')->toHtml();
        $expected = '<h1 id ="id" class="class">title</h1>';

        $this->assertSame($expected, $actual);
    }

    public function mockParsedown()
    {
        return Mockery::mock(\Parsedown::class);
    }

    public function mockParsedownExtra()
    {
        return Mockery::mock(\ParsedownExtra::class);
    }
}
