<?php
require 'vendor/autoload.php';

$template = __DIR__ . '/xml/template_25mb.xml';
//$template = __DIR__ . '/xml/template_small.xml';


////////////////////////////////////////////////////////////////////////////////////////////////////////

$start = microtime(true);

(new \App\RegexConverter(
    $template,
    __DIR__ . '/xml/result_regex.xml'
))->convert();

$time = microtime(true) - $start;
dump(sprintf('RegexConverter Time: %s s.', $time));

////////////////////////////////////////////////////////////////////////////////////////////////////////

$start = microtime(true);

(new \App\XmlReaderWriterConverter(
    $template,
    __DIR__ . '/xml/result_XmlReaderWriter.xml'
))->convert();

$time = microtime(true) - $start;
dump(sprintf('XmlReaderWriterConverter Time: %s s.', $time));

////////////////////////////////////////////////////////////////////////////////////////////////////////

$start = microtime(true);

(new \App\SabreXmlFileConverter(
    $template,
    __DIR__ . '/xml/result_Sabre.xml'
))->convert();

$time = microtime(true) - $start;
dump(sprintf('SabreXmlFileConverter Time: %s s.', $time));




