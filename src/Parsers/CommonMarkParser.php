<?php

namespace Haleks\Writedown\Parsers;

use League\CommonMark\Converter;

class CommonMarkParser extends Parser
{
    /**
     * The CommonMark instance.
     *
     * @var \League\CommonMark\Converter
     */
    protected $commonmark;

    /**
     * Create a new parser instance.
     *
     * @param  \League\CommonMark\Converter  $commonmark
     * @return void
     */
    public function __construct(Converter $commonmark)
    {
        $this->commonmark = $commonmark;
    }

    /**
     * Parse markdown content into HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->commonmark->convertToHtml($this->content);
    }
}
