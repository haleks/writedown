<?php

if (! function_exists('writedown')) {
    /**
     * Parse markdown content into HTML.
     *
     * @param  string  $content
     * @return string
     */
    function writedown($content)
    {
        return app('writedown')->content($content)->toHtml();
    }
}
