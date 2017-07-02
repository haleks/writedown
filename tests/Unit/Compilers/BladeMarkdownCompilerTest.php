<?php

namespace Haleks\Writedown\Tests\Unit\Compilers;

use Haleks\Writedown\Compilers\BladeMarkdownCompiler;

class BladeMarkdownCompilerTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->compiler = new BladeMarkdownCompiler($this->parser, $this->filesystem, __DIR__);
    }

    /** @test */
    public function it_can_compile_unescaped_blade_tags()
    {
        $actual = $this->compiler->compileString('{!! $foo !!}');
        $expected = '<?php echo $foo; ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_escaped_blade_tags()
    {
        $actual[] = $this->compiler->compileString('{{ $foo }}');
        $actual[] = $this->compiler->compileString('{{{ $foo }}}');
        $expected = '<?php echo e($foo); ?>';

        $this->assertSame($expected, $actual[0]);
        $this->assertSame($expected, $actual[1]);
    }

    /** @test */
    public function it_can_compile_untouched_blade_tags()
    {
        $actual = $this->compiler->compileString('@{{ foo }}');
        $expected = '{{ foo }}';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_unescaped_blade_tags_defaults()
    {
        $actual = $this->compiler->compileString('{!! $foo or \'bar\' !!}');
        $expected = '<?php echo isset($foo) ? $foo : \'bar\'; ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_escaped_blade_tags_defaults()
    {
        $actual[] = $this->compiler->compileString('{{ $foo or \'bar\' }}');
        $actual[] = $this->compiler->compileString('{{{ $foo or \'bar\' }}}');
        $expected = '<?php echo e(isset($foo) ? $foo : \'bar\'); ?>';

        $this->assertSame($expected, $actual[0]);
        $this->assertSame($expected, $actual[1]);
    }

    /** @test */
    public function it_can_compile_unescaped_blade_tags_and_parse_markdown_into_html()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# {!! $foo !!}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# <?php echo $foo; ?>');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());
    }

    // /** @test */
    public function it_can_compile_escaped_blade_tags_and_parse_markdown_into_html()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# {{ $foo }}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# <?php echo e($foo); ?>');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());

        $this->filesystem->shouldReceive('get')->once()->with('bar')->andReturn('# {{{ $bar }}}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('bar').'.php', '# <?php echo e($bar); ?>');

        $this->compiler->compile('bar');

        $this->assertEquals('bar', $this->compiler->getPath());
    }

    /** @test */
    public function it_can_compile_untouched_blade_tags_and_parse_markdown_into_html()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# @{{ foo }}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# {{ foo }}');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());
    }

    /** @test */
    public function it_can_compile_unescaped_blade_tags_defaults_and_parse_markdown_into_html()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# {!! $foo or \'bar\' !!}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# <?php echo isset($foo) ? $foo : \'bar\'; ?>');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());
    }

    /** @test */
    public function it_can_compile_escaped_blade_tags_defaults_and_parse_markdown_into_html()
    {
        $this->filesystem->shouldReceive('get')->once()->with('foo')->andReturn('# {{ $foo or \'bar\' }}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('foo').'.php', '# <?php echo e(isset($foo) ? $foo : \'bar\'); ?>');

        $this->compiler->compile('foo');

        $this->assertEquals('foo', $this->compiler->getPath());

        $this->filesystem->shouldReceive('get')->once()->with('bar')->andReturn('# {{{ $bar or \'foo\' }}}');
        $this->filesystem->shouldReceive('put')->once()->with(__DIR__.'/'.sha1('bar').'.php', '# <?php echo e(isset($bar) ? $bar : \'foo\'); ?>');

        $this->compiler->compile('bar');

        $this->assertEquals('bar', $this->compiler->getPath());
    }

    /** @test */
    public function it_can_compile_markdown_into_html()
    {
        $this->parser->shouldReceive('content')->once()->with('# title')->andReturn($this->parser);
        $this->parser->shouldReceive('toHtml')->once()->andReturn('<h1>title</h1>');

        $actual = $this->compiler->compileMarkdown('# title');
        $expected = '<h1>title</h1>';

        $this->assertEquals($actual, $expected);
    }

}
