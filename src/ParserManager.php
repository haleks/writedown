<?php

namespace Haleks\Writedown;

use Parsedown;
use ParsedownExtra;
use Michelf\Markdown;
use Michelf\MarkdownExtra;
use Illuminate\Support\Manager;
use League\CommonMark\Environment;
use Haleks\Writedown\Parsers\NullParser;
use Haleks\Writedown\Parsers\MarkdownParser;
use Haleks\Writedown\Parsers\ParsedownParser;
use Haleks\Writedown\Parsers\CommonMarkParser;
use League\CommonMark\CommonMarkConverter as CommonMark;

class ParserManager extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function parser($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create an Parsedown parser instance.
     *
     * @return \Haleks\Writedown\Parsers\ParsedownParser
     */
    public function createParsedownDriver()
    {
        return new ParsedownParser($this->newParser('parsedown'));
    }

    /**
     * Create an ParsedownExtra parser instance.
     *
     * @return \Haleks\Writedown\Parsers\ParsedownParser
     */
    public function createParsedownExtraDriver()
    {
        return new ParsedownParser($this->newParser('parsedownextra'));
    }

    /**
     * Create an Markdown parser instance.
     *
     * @return \Haleks\Writedown\Parsers\MarkdownParser
     */
    public function createMarkdownDriver()
    {
        return new MarkdownParser($this->newParser('markdown'));
    }

    /**
     * Create an MarkdownExtra parser instance.
     *
     * @return \Haleks\Writedown\Parsers\MarkdownParser
     */
    public function createMarkdownExtraDriver()
    {
        return new MarkdownParser($this->newParser('markdownextra'));
    }

    /**
     * Create an CommonMark parser instance.
     *
     * @return \Haleks\Writedown\Parsers\CommonMarkParser
     */
    public function createCommonmarkDriver()
    {
        return new CommonMarkParser($this->newParser('commonmark'));
    }

    /**
     * Create a Null parser instance.
     *
     * @return \Haleks\Writedown\Parsers\NullParser
     */
    public function createNullDriver()
    {
        return new NullParser;
    }

    /**
     * Get the default parser driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $default = $this->app['config']['writedown.default'];

        return $default === 'null' ? $default : $this->getConfigDriver($default);
    }

    /**
     * Get the requested parser configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["writedown.parsers.{$name}"];
    }

    /**
     * Get the requested parser driver.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfigDriver($name)
    {
        return $this->getConfig($name)['driver'];
    }

    /**
     * Create a new parser instance.
     *
     * @return mixed
     */
    protected function newParser($name)
    {
        $config = $this->getConfig($name);

        $parser = $this->{'new'.$name}();

        // Remove trailing 'extra'.
        $name = rtrim($name, 'extra');

        // Check if parser's configurations are set.
        if (isset($config['config'])) {
            $this->{'set'.$name.'Config'}($parser, $config['config']);
        }

        // Check if parser's extensions exists.
        if (! empty($config['extensions'])) {
            $this->{'add'.$name.'Extensions'}($parser, $config['extensions']);
        }

        // The CommonMark Converter requires an instance of CommonaMark Environment
        // which needs to be configured and extended prior to initializing which
        // is the current variable "$parser". After we now have to initialize
        // a CommonMark Converter with the current CommonMark Environment.
        if ($name == 'commonmark') {
            return $this->newCommonMarkConverter($parser);
        }

        return $parser;
    }

    /**
     * Return a new Parsedown instance.
     *
     * @return \Parsedown
     */
    protected function newParsedown()
    {
        return new Parsedown;
    }

    /**
     * Return a new ParsedownExtra instance.
     *
     * @return \ParsedownExtra
     */
    protected function newParsedownextra()
    {
        return new ParsedownExtra;
    }

    /**
     * Return a new ParsedownExtra instance.
     *
     * @return \ParsedownExtra
     */
    protected function newMarkdown()
    {
        return new Markdown;
    }

    /**
     * Return a new ParsedownExtra instance.
     *
     * @return \ParsedownExtra
     */
    protected function newMarkdownExtra()
    {
        return new MarkdownExtra;
    }

    /**
     * Return a new Environment instance.
     *
     * @return \League\CommonMark\Environment
     */
    protected function newCommonMark()
    {
        return Environment::createCommonMarkEnvironment();
    }

    /**
     * Return a new CommonMark Converter instance.
     *
     * @return \League\CommonMark\CommonMarkConverter
     */
    protected function newCommonMarkConverter($environment)
    {
        return new CommonMark([], $environment);
    }

    /**
     * Set the configuration to the Parsedown instance.
     *
     * @return void
     */
    protected function setParsedownConfig(&$parsedown, $options)
    {
        foreach ($options as $option => $value) {
            $parsedown->{'set'.studly_case($option)}($value);
        }
    }

    /**
     * Set the configuration to the Markdown instance.
     *
     * @return void
     */
    protected function setMarkdownConfig(&$markdown, $options)
    {
        foreach ($options as $option => $value) {
            $markdown->$option = $value;
        }
    }

    /**
     * Set the configuration to the CommonMark environment instance.
     *
     * @return void
     */
    protected function setCommonMarkConfig(&$environment, $config)
    {
        $environment->mergeConfig($config);
    }

    /**
     * Add extensions to the CommonMark environment instance.
     *
     * @return void
     */
    protected function addCommonMarkExtensions(&$environment, $extensions)
    {
        foreach ($extensions as $extension) {
            if (class_exists($extension)) {
                $environment->addExtension(new $extension());
            }
        }
    }
}
