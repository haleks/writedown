<?php

namespace Haleks\Writedown\Tests\Unit\Compilers;

use Haleks\Writedown\Compilers\BladeCompiler;

class BladeCompilerTest extends \Haleks\Writedown\Tests\Unit\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->compiler = new BladeCompiler($this->filesystem, __DIR__);
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
    public function it_can_compile_markdown_tags()
    {
        $actual = $this->compiler->compileString('{% $foo %}');
        $expected = '<?php echo writedown($foo); ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_markdown_tags_defaults()
    {
        $actual = $this->compiler->compileString('{% $foo or \'bar\'%}');
        $expected = '<?php echo writedown(isset($foo) ? $foo : \'bar\'); ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_untouched_markdown_tags()
    {
        $actual = $this->compiler->compileString('@{% foo %}');
        $expected = '{% foo %}';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_markdown_directives_expressions()
    {
        $actual = $this->compiler->compileString('@writedown(\'foo\')');
        $expected = '<?php echo writedown(\'foo\'); ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_markdown_directives_block()
    {
        $actual = $this->compiler->compileString('@writedown foo @endwritedown');
        $expected = '<?php echo writedown(\' foo \'); ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_markdown_directives_alias_expressions()
    {
        $actual = $this->compiler->compileString('@markdown(\'foo\')');
        $expected = '<?php echo writedown(\'foo\'); ?>';

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_markdown_directives_alias_block()
    {
        $actual = $this->compiler->compileString('@markdown foo @endmarkdown');
        $expected = '<?php echo writedown(\' foo \'); ?>';

        $this->assertSame($expected, $actual);
    }


}
