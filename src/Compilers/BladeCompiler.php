<?php

namespace Haleks\Writedown\Compilers;

use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler implements CompilerInterface
{
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

    /**
     * Get the echo methods in the proper order for compilation.
     *
     * @return array
     */
    protected function getEchoMethods()
    {
        $methods = [
            'compileRawEchos' => strlen(stripcslashes($this->rawTags[0])),
            'compileEscapedEchos' => strlen(stripcslashes($this->escapedTags[0])),
            'compileMarkdownEchos' => strlen(stripcslashes($this->markdownTags[0])),
            'compileRegularEchos' => strlen(stripcslashes($this->contentTags[0])),
        ];

        uksort($methods, function ($method1, $method2) use ($methods) {
            // Ensure the longest tags are processed first
            if ($methods[$method1] > $methods[$method2]) {
                return -1;
            }
            if ($methods[$method1] < $methods[$method2]) {
                return 1;
            }

            // Otherwise give preference to raw tags (assuming they've overridden)
            if ($method1 === 'compileRawEchos') {
                return -1;
            }
            if ($method2 === 'compileRawEchos') {
                return 1;
            }

            if ($method1 === 'compileEscapedEchos') {
                return -1;
            }
            if ($method2 === 'compileEscapedEchos') {
                return 1;
            }
        });

        return $methods;
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
            $wrapper = sprintf($this->markdownFormat, $this->compileEchoDefaults($matches[2]));

            return $matches[1] ? strlen(stripcslashes($this->markdownTags[0])) > 2 ? $matches[0] : substr($matches[0], 1) : '<?php echo '.$wrapper.'; ?>';
        };

        return preg_replace_callback($pattern, $callback, $value);
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
     * Sets the escaped content tags used for the compiler.
     *
     * @param  string  $openTag
     * @param  string  $closeTag
     * @return void
     */
    public function setMarkdownTags($openTag, $closeTag)
    {
        $this->markdownTags = [preg_quote($openTag), preg_quote($closeTag)];
    }

    /**
     * Gets the tags used for the compiler.
     *
     * @param  bool  $escaped
     * @return array
     */
    protected function getMarkdownTags()
    {
        return $this->markdownTags;
    }
}
