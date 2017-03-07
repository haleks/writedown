<?php

namespace Haleks\Writedown;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Haleks\Writedown\Engines\CompilerEngine;
use Haleks\Writedown\Compilers\BladeCompiler;
use Haleks\Writedown\Compilers\MarkdownCompiler;
use Haleks\Writedown\Compilers\BladeMarkdownCompiler;
use Illuminate\View\Engines\CompilerEngine as BaseCompilerEngine;

class WritedownServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/writedown.php' => config_path('writedown.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/writedown.php', 'writedown');

        $this->registerWritedown();
        $this->registerCompilersEngines();
    }

    /**
     * Register the Writedown parser.
     *
     * @return void
     */
    protected function registerWritedown()
    {
        $this->app->singleton('writedown', function ($app) {
            return new ParserManager($app);
        });

        $this->app->singleton('writedown.parser', function ($app) {
            return (new ParserManager($app))->parser();
        });

        $this->app->alias('writedown', ParserManager::class);
    }

    /**
     * Register the Writedown compilers and engines.
     *
     * @return void
     */
    protected function registerCompilersEngines()
    {
        $resolver = $this->app['view.engine.resolver'];

        if ($this->app['config']['writedown.extend']) {
            $this->registerBladeEngine($resolver);
        }

        if ($this->app['config']['writedown.views']) {
            $this->registerMarkdownBladeEngine($resolver);
            $this->registerMarkdownEngine($resolver);
        }
    }

    /**
     * Overwrite the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerBladeEngine($resolver)
    {
        $app = $this->app;

        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $app->singleton('blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new BladeCompiler($app['files'], $cache);
        });

        $resolver->register('blade', function () use ($app) {
            return new BaseCompilerEngine($app['blade.compiler']);
        });
    }

    /**
     * Register the Markdown engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerMarkdownBladeEngine($resolver)
    {
        $app = $this->app;

        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Markdown compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $app->singleton('markdownblade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new BladeMarkdownCompiler($app['writedown.parser'], $app['files'], $cache);
        });

        $resolver->register('markdownblade', function () use ($app) {
            return new CompilerEngine($app['markdownblade.compiler']);
        });

        // Add markdown file extension to the view instance and
        // make the view instance to use the Markdown engine.
        $app['view']->addExtension('md.blade.php', 'markdownblade');
        $app['view']->addExtension('md-blade.php', 'markdownblade');
    }

    /**
     * Register the Markdown engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerMarkdownEngine($resolver)
    {
        $app = $this->app;

        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Markdown compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $app->singleton('markdown.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new MarkdownCompiler($app['writedown.parser'], $app['files'], $cache);
        });

        $resolver->register('markdown', function () use ($app) {
            return new CompilerEngine($app['markdown.compiler']);
        });

        // Add markdown file extension to the view instance and
        // make the view instance to use the Markdown engine.
        $app['view']->addExtension('md', 'markdown');
        $app['view']->addExtension('md.php', 'markdown');
    }
}
