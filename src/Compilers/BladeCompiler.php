<?php

namespace Haleks\Writedown\Compilers;

use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
    use Concerns\CompilesEchos,
        Concerns\CompilesMarkdown;

    /**
     * Array of opening and closing tags for markdown echos.
     *
     * @var array
     */
    protected $markdownTags = ['{%', '%}'];

    /**
     * The markdown string format.
     *
     * @var string
     */
    protected $markdownFormat = 'writedown(%s)';
}
