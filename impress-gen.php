<?php

namespace ImpressGen;

require_once 'lib/Translate.php';
require_once 'lib/Markdown.php';
require_once 'lib/Cli.php';

try {
    $t = new Lib\Translate();
    $c = new Lib\Cli();
    $c->handle();

    // if it's --help, short circuit
    if ($c->getOption('help') !== null) {
        $c->displayHelp();
        die();
    }

    $dir = __DIR__.'/sample-presentation';
    $t->parse($dir,$c);
} catch(\Exception $e) {
    echo "ERROR: ".$e->getMessage()."\n\n";
}

?>
