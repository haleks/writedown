<?php

namespace Haleks\Writedown\Parsers;

use Parsedown;

class ParsedownParser extends Parser
{
    /**
     * The Parsedown instance.
     *
     * @var \Parsedown
     */
    protected $parsedown;

    /**
     * Create a new parser instance.
     *
     * @param  \Parsedown  $parsedown
     * @return void
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * Parse markdown content into HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->parsedown->text($this->content);
    }
}
