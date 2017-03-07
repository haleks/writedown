<?php

namespace Haleks\Writedown\Tests\Intergration;

class WritedownServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_register_writedown()
    {
        $this->assertInstanceOf(\Haleks\Writedown\ParserManager::class, $this->app['writedown']);
    }

    /** @test */
    public function it_can_register_writedown_null_parser()
    {
        $this->assertInstanceOf(\Haleks\Writedown\Parsers\NullParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_register_writedown_parsedown_parser()
    {
        $this->app['config']['writedown.default'] = 'parsedown';

        $this->assertInstanceOf(\Haleks\Writedown\Parsers\ParsedownParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_register_writedown_parsedown_extra_parser()
    {
        $this->app['config']['writedown.default'] = 'parsedownextra';

        $this->assertInstanceOf(\Haleks\Writedown\Parsers\ParsedownParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_register_writedown_markdown_parser()
    {
        $this->app['config']['writedown.default'] = 'markdown';

        $this->assertInstanceOf(\Haleks\Writedown\Parsers\MarkdownParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_register_writedown_markdown_extra_parser()
    {
        $this->app['config']['writedown.default'] = 'markdownextra';

        $this->assertInstanceOf(\Haleks\Writedown\Parsers\MarkdownParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_register_writedown_commonmark_parser()
    {
        $this->app['config']['writedown.default'] = 'commonmark';

        $this->assertInstanceOf(\Haleks\Writedown\Parsers\CommonMarkParser::class, $this->app['writedown.parser']);
    }

    /** @test */
    public function it_can_enable_writedown_blade_tags()
    {
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $this->assertInstanceOf(\Haleks\Writedown\Compilers\BladeCompiler::class, $this->app['blade.compiler']);
    }

    /** @test */
    public function it_can_ignore_writedown_blade_tags()
    {
        $this->app['config']['writedown.extend'] = false;

        $this->provider->register();

        $this->assertNotInstanceOf(\Haleks\Writedown\Compilers\BladeCompiler::class, $this->app['blade.compiler']);
        $this->assertInstanceOf(\Illuminate\View\Compilers\BladeCompiler::class, $this->app['blade.compiler']);
    }

    /** @test */
    public function it_can_enable_writedown_views()
    {
        $this->app['config']['writedown.views'] = true;

        $this->provider->register();

        $actual = $this->app['view']->getExtensions();
        $expected = [
            'md.php' => 'markdown',
            'md' => 'markdown',
            'md-blade.php' => 'markdownblade',
            'md.blade.php' => 'markdownblade',
            'blade.php' => 'blade',
            'php' => 'php',
        ];

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_ignore_writedown_views()
    {
        $this->app['config']['writedown.views'] = false;

        $this->provider->register();

        $actual = $this->app['view']->getExtensions();
        $expected = [
            'blade.php' => 'blade',
            'php' => 'php',
        ];

        $this->assertSame($expected, $actual);
    }
}
