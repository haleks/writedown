<?php

namespace Haleks\Writedown\Compilers;

use Haleks\Writedown\Parsers\Parser;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeMarkdownCompiler extends BaseBladeCompiler implements CompilerInterface
{
    /**
     * The parser instance.
     *
     * @var string
     */
    protected $parser;

    /**
     * Create a new compiler instance.
     *
     * @param  \Haleks\Writedown\Parsers\Parser  $parser
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $cachePath
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Parser $parser, Filesystem $files, $cachePath)
    {
        if (! $cachePath) {
            throw new InvalidArgumentException('Please provide a valid cache path.');
        }

        $this->parser = $parser;
        $this->files = $files;
        $this->cachePath = $cachePath;
    }

    /**
     * Compile the view at the given path.
     *
     * @param  string  $path
     * @return void
     */
    public function compile($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        if (! is_null($this->cachePath)) {
            $contents = $this->compileString($this->files->get($this->getPath()));

            $this->files->put($this->getCompiledPath($this->getPath()), $contents);
        }
    }

    /**
     * Compile the given Markdown expression into valid HTML.
     *
     * @param  string  $expression
     * @return string
     */
    public function compileMarkdown($expression)
    {
        return $this->parser->content($expression)->toHtml();
    }
}
