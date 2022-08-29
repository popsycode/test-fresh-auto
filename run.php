<?php

use phpDocumentor\Reflection\Types\ClassString;
use Symfony\Component\Finder\Finder;

require 'vendor/autoload.php';

$template = __DIR__ . '/xml/template_25mb.xml';
//$template = __DIR__ . '/xml/template_small.xml';

/** @var SplFileInfo $file */
foreach ((new Finder())->in(__DIR__.'/src')->files() as $file) {

    /** @var  ClassString|class-string<\App\IXmlFileConverter> $classStr */
    $classStr = 'App\\'.str_replace('.php', '', $file->getFilename());

    $reflection = new ReflectionClass($classStr);
    if(
        is_subclass_of($classStr, \App\IXmlFileConverter::class)
        && ! $reflection->isAbstract()
    ){

        $start = microtime(true);
        (new $classStr(
            $template,
            __DIR__ . '/xml/result_'.mb_strtolower($reflection->getShortName()).'.xml'
        ))->convert();

        $time = microtime(true) - $start;
        dump(sprintf('%s Time: %s s.', $classStr, $time));

    }
}





