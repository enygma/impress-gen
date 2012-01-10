<?php

namespace Lib;

/**
 * As defined here: http://www.squarespace.com/display/ShowHelp?section=Markdown
 */

class Markdown
{
    public function parse($contents)
    {

        // run all of our formatting methods
        $rclass = new \ReflectionClass('Lib\Markdown');
        foreach ($rclass->getMethods() as $method) {
            $methodName = $method->name;
            if(substr($methodName,0,7) == '_format'){
                $contents = $this->$methodName($contents);
            }
        }
        return $contents;
    }

    private function _formatBold($contents)
    {
        return preg_replace('/(\*|#){2}(.+?)(\*|#){2}/ms', '<strong>$2</strong>', $contents);
    }
    private function _formatItalic($contents)
    {
        return preg_replace('/(\*|#){1}(.+?)(\*|#){1}/ms', '<i>$2</i>', $contents);
    }
    private function _formatHeadline1($contents)
    {
        return preg_replace('/(.+?)\\n(=+)\\n/ms','<h1>$1</h1>',$contents);
    }
    private function _formatHeadline2($contents)
    {
        return preg_replace('/(.+?)\\n(\-+)\\n/ms','<h2>$1</h2>',$contents);
    }
    private function _formatParagraph($contents)
    {
        return preg_replace('/\\n\\n(.+?)\\n/','<p>$1</p>',$contents);
    }
}

?>