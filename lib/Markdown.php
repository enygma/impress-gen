<?php

namespace ImpressGen\Lib;

/**
 * As defined here: http://www.squarespace.com/display/ShowHelp?section=Markdown
 */

class Markdown
{
    /**
     * Parse the markdown syntax
     *
     * @param string $contents Markdown file contents
     *
     * @return string $contents Formatted results
     */
    public function parse($contents)
    {

        // run all of our formatting methods
        $rclass = new \ReflectionClass('\ImpressGen\Lib\Markdown');
        foreach ($rclass->getMethods() as $method) {
            $methodName = $method->name;
            if(substr($methodName,0,7) == '_format'){
                $contents = $this->$methodName($contents);
            }
        }
        return $contents;
    }

    /**
     * Format markdown syntax for bold text
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatBold($contents)
    {
        return preg_replace('/(\*|#){2}(.+?)(\*|#){2}/ms', '<strong>$2</strong>', $contents);
    }

    /**
     * Format markdown syntax for italicized text
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatItalic($contents)
    {
        return preg_replace('/(\*|#){1}(.+?)(\*|#){1}/ms', '<i>$2</i>', $contents);
    }

    /**
     * Format markdown syntax for header, lvl1 tags (h1)
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatHeadline1($contents)
    {
        return preg_replace('/(.+?)\\n(=+)\\n/ms','<h1>$1</h1>',$contents);
    }

    /**
     * Format markdown syntax for header, lvl2 tags (h2)
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatHeadline2($contents)
    {
        return preg_replace('/(.+?)\\n(\-+)\\n/ms','<h2>$1</h2>',$contents);
    }

    /**
     * Format markdown syntax for paragraph tags
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatParagraph($contents)
    {
        return preg_replace('/\\n\\n(.+?)\\n/','<p>$1</p>',$contents);
    }

    /**
     * Format markdown syntax and replace with anchor tags
     * match: [prezi.com](http://prezi.com "prezi.com")
     * 
     * @param string $contents Contents of the markdown file
     * 
     * @return string $contents Formatted contents
     */
    private function _formatAnchor($contents)
    {
        preg_match('/\[(.+?\]\((.+?) "(.+?)"\))/',$contents,$match);

        if (!empty($match[0])) {
            $contents = str_replace($match[0],'<a href="'.$match[2].'">'.$match[3].'</a>',$contents);    
        }

        return $contents;
    }
}

?>
