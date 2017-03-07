<?php

namespace Haleks\Writedown\Parsers;

use Illuminate\Contracts\Support\Htmlable;

abstract class Parser implements Htmlable
{
    /**
     * The markdown content.
     *
     * @var mixed
     */
    protected $content;

    /**
     * Add markdown content to be parsed.
     *
     * @param  mixed  $content
     * @return void
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Parse markdown content into HTML.
     *
     * @return string
     */
    abstract public function toHtml();

    /**
     * Parse markdown content into HTML.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
