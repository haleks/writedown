<?php

namespace Haleks\Writedown\Compilers\Concerns;

use Illuminate\View\Compilers\Concerns\CompilesEchos as BaseCompilesEchos;

trait CompilesEchos
{
    use BaseCompilesEchos;

    /**
     * Get the echo methods in the proper order for compilation.
     *
     * @return array
     */
    protected function getEchoMethods()
    {
        return [
            'compileRawEchos',
            'compileEscapedEchos',
            'compileMarkdownEchos',
            'compileRegularEchos',
        ];
    }

    /**
     * Compile markdown into valid html.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileMarkdownEchos($value)
    {
        $pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->markdownTags[0], $this->markdownTags[1]);

        $callback = function ($matches) {
            $whitespace = empty($matches[3]) ? '' : $matches[3].$matches[3];

            $wrapped = sprintf($this->markdownFormat, $matches[2]);

            return $matches[1] ? substr($matches[0], 1) : "<?php echo {$wrapped}; ?>{$whitespace}";
        };

        return preg_replace_callback($pattern, $callback, $value);
    }
}
