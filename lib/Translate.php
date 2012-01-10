<?php

namespace Lib;

class Translate
{
    
    
    public function parse($dirPath)
    {
        $md = new \Lib\Markdown();

        $output = <<<EOT
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link href="css/impress-demo.css" rel="stylesheet" />
</head>
<body>
    <div id="impress" class="impress-not-supported">

EOT;

        // ensure we can read the directory
        if (is_dir($dirPath)) {
            $iterator = new \DirectoryIterator($dirPath);
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $contents       = file_get_contents($file->getPathname());
                    $attributeSet   = array();

                    $slideName = $file->getBasename('.md');

                    // pull off the first line if it's an attributes line
                    if (substr($contents, 0, 5) == '<!---') {
                        $lines = explode("\n", $contents);
                        $attributes = array_shift($lines);
                        $contents = implode("\n", $lines);

                        $attributes = str_replace(
                            array('<!---','--->'),'', $attributes
                        );
                        $attribSet  = explode(",", $attributes);

                        foreach ($attribSet as $attrib) {
                            $ex = explode("=", $attrib);
                            $attributeSet[$ex[0]] = trim($ex[1]);
                        }
                    }

                    $content    = $md->parse($contents);
                    $attribList = '';

                    foreach ($attributeSet as $property => $value) {
                        $attribList .= $property.'="'.$value.'" ';
                    }
                    $attribList = trim($attribList);

                    $output .= <<<EOT
            <div $attribList>
                $content
            </div>

EOT;
                }
            }
        }

        $output .= <<<EOT

    </div>
    <script src="js/impress.js"></script>
</body>
</html>
EOT;

        // write out to the file
        $filePath = '/www/htdocs/test/impress/index.html';
        file_put_contents($filePath, $output);
        echo "outputted to ".$filePath."\n\n";
    }


}

?>