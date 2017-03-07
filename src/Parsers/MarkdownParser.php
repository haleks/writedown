<?php

namespace Haleks\Writedown\Parsers;

use Michelf\Markdown;

class MarkdownParser extends Parser
{
    /**
     * The Markdown instance.
     *
     * @var \Michelf\Markdown
     */
    protected $markdown;

    /**
     * Create a new parser instance.
     *
     * @param  \Michelf\Markdown  $markdown
     * @return void
     */
    public function __construct(Markdown $markdown)
    {
        $this->markdown = $markdown;
    }

    /**
     * Parse markdown content into HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->markdown->transform($this->content);
    }
}
