<?php

namespace ImpressGen\Lib;

class Translate
{
    public function parse($dirPath,$options=null)
    {
        $md = new Markdown();

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
        // if the source is set on the command line, override
        $dirPath = ($options->getOption('source') !== null) ? $options->getOption('source') : $dirPath;
        echo 'Loading from: '.$dirPath."\n\n";

        // ensure we can read the directory
        if (is_dir($dirPath)) {
            $iterator = new \DirectoryIterator($dirPath);
            $fileList = array();

            foreach ($iterator as $file) {
                if ($file->isFile() && stristr($file->getBasename(),'.md') !== false) {
                    $contents       = file_get_contents($file->getPathname());
                    $attributeSet   = array();
                    $fileList[]     = $file->getBasename();

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

        if (empty($fileList)) {
            throw new \Exception('No valid markdown files/slides found!');
        }

        $output .= <<<EOT

    </div>
    <script src="js/impress.js"></script>
</body>
</html>
EOT;
        $filePath = ($options->getOption('output') !== null) 
            ? $options->getOption('output') : '/www/htdocs/test/impress/index.html';

        // write out to the file
        file_put_contents($filePath, $output);
        echo "Presentation output in ".$filePath."\n\n";
    }


}

?>
