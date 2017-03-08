<?php

namespace Haleks\Writedown\Compilers\Concerns;

trait CompilesMarkdown
{
    /**
     * Compile the raw Writedown statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileWritedown($expression)
    {
        return $expression ? "<?php echo writedown$expression; ?>" : '<?php echo writedown(\'';
    }

    /**
     * Compile end Writedown statement into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndwritedown($expression)
    {
        return '\'); ?>';
    }

    /**
     * Alias for Writedown directive.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileMarkdown($expression)
    {
        return $this->compileWritedown($expression);
    }

    /**
     * Alias for end Writedown directive.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndmarkdown($expression)
    {
        return $this->compileEndwritedown($expression);
    }
}
