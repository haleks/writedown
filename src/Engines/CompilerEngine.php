<?php

namespace Haleks\Writedown\Engines;

use Illuminate\View\Engines\CompilerEngine as BaseCompilerEngine;

class CompilerEngine extends BaseCompilerEngine
{
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        $results = parent::get($path, $data);

        return $this->compiler->compileMarkdown($results);
    }
}
