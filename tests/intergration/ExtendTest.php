<?php

namespace Haleks\Writedown\Tests\Intergration;

class ExtendTest extends TestCase
{
    /** @test */
    public function it_can_compile_blade_views_writedown_tags_with_parsedown()
    {
        $this->app['config']['writedown.default'] = 'parsedown';
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n<p>text</p>\n<p>{% ignore %}</p>\n<p>expression</p><p>block</p>";

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_blade_views_writedown_tags_with_parsedown_extra()
    {
        $this->app['config']['writedown.default'] = 'parsedownextra';
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n<p>text</p>\n<p>{% ignore %}</p>\n<p>expression</p><p>block</p>";

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_blade_views_writedown_tags_with_markdown()
    {
        $this->app['config']['writedown.default'] = 'markdown';
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n<p>text</p>\n\n<p>{% ignore %}</p>\n<p>expression</p>\n<p>block</p>\n";

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_blade_views_writedown_tags_with_markdown_extra()
    {
        $this->app['config']['writedown.default'] = 'markdownextra';
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n<p>text</p>\n\n<p>{% ignore %}</p>\n<p>expression</p>\n<p>block</p>\n";

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_blade_views_writedown_tags_with_commonmark()
    {
        $this->app['config']['writedown.default'] = 'commonmark';
        $this->app['config']['writedown.extend'] = true;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n<p>text</p>\n\n<p>{% ignore %}</p>\n<p>expression</p>\n<p>block</p>\n";

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_can_compile_blade_views_ignoring_writedown_tags()
    {
        $this->app['config']['writedown.extend'] = false;

        $this->provider->register();

        $actual = $this->app['view']->make('blade')->render();
        $expected = "<h1>title</h1>\n{% 'text' %}\n<p>@{% ignore %}</p>\n@writedown('expression')\n@writedown\nblock\n@endwritedown\n";

        $this->assertSame($expected, $actual);
    }
}
