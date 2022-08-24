<?php
require 'vendor/autoload.php';

//$template = __DIR__ . '/xml/template_25mb.xml';
$template = __DIR__ . '/xml/template_small.xml';

$converter = \App\XmlReaderWriterConverter::class;
//$converter = \App\SabreXmlFileConverter::class;

(new $converter(
    $template,
    __DIR__ . '/xml/result.xml'
))->convert();
