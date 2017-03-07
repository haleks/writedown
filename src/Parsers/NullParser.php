<?php

namespace Haleks\Writedown\Parsers;

class NullParser extends Parser
{
    /**
     * Return unparsed content.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->content;
    }
}
