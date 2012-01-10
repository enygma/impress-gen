<?php

require_once 'lib/Translate.php';
require_once 'lib/Markdown.php';

$t = new \Lib\Translate();

var_dump($t);

$dir = __DIR__.'/sample-presentation';
$t->parse($dir);

?>