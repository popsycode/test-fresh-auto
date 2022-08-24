<?php

declare(strict_types=1);

namespace App;

use XMLReader;
use XMLWriter;
use XMLWritingIteration;

class XmlReaderWriterConverter extends AbstractXmlFileConverter
{

    private XMLReader $reader;
    private XMLWriter $writer;

    public function __construct(string $inputFilePath, string $outputFilePath)
    {
        parent::__construct($inputFilePath, $outputFilePath);
        $this->reader = new XMLReader();
        $this->writer = new XMLWriter();
    }

    public function convert(): XmlReaderWriterConverter
    {
        $reader = $this->reader;
        $reader->open($this->inputFilePath);

        $writer = $this->writer;
        $writer->openUri($this->outputFilePath);

        $iterator = new XMLWritingIteration($writer, $reader);
        $writer->startDocument();

        /** @var XMLReader */
        foreach ($iterator as $node) {
            switch ($node->nodeType){
                case XMLReader::ELEMENT:
                case XMLReader::DOC_TYPE:
                    $writer->startElement(strrev($node->name));
                    if ($node->moveToFirstAttribute()) {
                        do {
                            $writer->writeAttribute(strrev($node->name), strrev($node->value));
                        } while ($node->moveToNextAttribute());
                        $node->moveToElement();
                    }

                    if ($node->isEmptyElement) {
                        $writer->endElement();
                    }
                    break;
                case XMLReader::TEXT:
                    $writer->text(strrev($node->value));
                    break;
                default:
                    $iterator->write();
            }
        }
        $writer->endDocument();
        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        dump($name);
    }
}
