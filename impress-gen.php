<?php

require_once 'lib/Translate.php';
require_once 'lib/Markdown.php';

$t = new \Lib\Translate();

$dir = __DIR__.'/sample-presentation';
$t->parse($dir);

?>