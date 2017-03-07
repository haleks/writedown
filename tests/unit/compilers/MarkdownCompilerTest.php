<?php

namespace Haleks\Writedown\Tests\Unit\Compilers;

use Haleks\Writedown\Compilers\MarkdownCompiler;

class MarkdownCompilerTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->compiler = new MarkdownCompiler($this->parser, $this->filesystem, __DIR__);
    }

    /** @test */
    public function it_can_compile_markdown_into_html()
    {
        $this->parser->shouldReceive('content')->once()->with('# title')->andReturn($this->parser);
        $this->parser->shouldReceive('toHtml')->once()->andReturn('<h1>title</h1>');

        $actual = $this->compiler->compileMarkdown('# title');
        $expected = '<h1>title</h1>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_get_the_markdown_path()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# title');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# title');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());
    }

    /** @test */
    public function it_can_set_the_markdown_path()
    {
        $this->compiler->setPath('foo');

        $this->assertEquals('foo', $this->compiler->getPath());
    }
}
