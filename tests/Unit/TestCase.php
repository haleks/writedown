<?php

namespace Haleks\Writedown\Tests\Unit;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $parser;
    protected $filesystem;
    protected $compiler;

    protected function setUp()
    {
        $this->parser = \Mockery::mock(\Haleks\Writedown\Parsers\Parser::class);
        $this->filesystem = \Mockery::mock(\Illuminate\Filesystem\Filesystem::class);
    }

    protected function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }
}
