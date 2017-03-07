<?php

namespace Haleks\Writedown\Compilers;

use Haleks\Writedown\Parsers\Parser;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;

class MarkdownCompiler extends Compiler implements CompilerInterface
{
    /**
     * The parser instance.
     *
     * @var string
     */
    protected $parser;

    /**
     * The file currently being compiled.
     *
     * @var string
     */
    protected $path;

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
            $this->files->put($this->getCompiledPath($this->getPath()), $this->files->get($this->getPath()));
        }
    }

    /**
     * Get the path currently being compiled.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path currently being compiled.
     *
     * @param  string  $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Compile the given Markdown contents.
     *
     * @param  string  $contents
     * @return string
     */
    public function compileMarkdown($contents)
    {
        return $this->parser->content($contents)->toHtml();
    }
}
