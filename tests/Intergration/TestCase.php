<?php

namespace Haleks\Writedown\Tests\Intergration;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $provider;

    protected function setUp()
    {
        parent::setUp();

        $this->app['view']->addLocation(__DIR__.'/fixture');

        $this->provider = new \Haleks\Writedown\WritedownServiceProvider($this->app);
    }

    protected function tearDown()
    {
        $this->artisan('view:clear');

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Haleks\Writedown\WritedownServiceProvider::class
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']['writedown.extend'] = false;
        $app['config']['writedown.views'] = false;
    }
}
