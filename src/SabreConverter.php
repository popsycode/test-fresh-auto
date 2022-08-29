<?php

declare(strict_types=1);

namespace App;


use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;

/**
 * @psalm-type TNode = array{name: string, attributes: array, value: mixed}
 */

class SabreConverter extends AbstractXmlFileConverter
{
    private Reader $reader;
    private Writer $writer;

    public function __construct(string $inputFilePath, string $outputFilePath)
    {
        parent::__construct($inputFilePath, $outputFilePath);
        $this->reader = new Reader();
        $this->writer = new Writer();
    }

    /**
     * @throws LibXMLException
     */
    public function convert(): SabreConverter
    {
        $this->reader->xml(file_get_contents($this->inputFilePath));
        /** @var TNode $content */
        $content = $this->reader->parse();
        $content = $this->transformNode($content);
        $this->writer->openMemory();
        $this->writer->setIndent(true);
        $this->writer->startDocument();
        $this->writer->write($content);
        file_put_contents($this->outputFilePath, $this->writer->outputMemory());
        return $this;
    }

    /**
     * @param  TNode $node
     * @return TNode
     */
    private static function transformNode(array $node): array
    {
        $node['name'] = self::strrev($node['name']);

        if(count($node['attributes'])){
            $node['attributes'] = [];
            foreach ($node['attributes'] as $name => $value){
                $node['attributes'][self::strrev($name)] = self::strrev($value);
            }
        }

        $node['value'] = match (gettype($node['value'])) {
            'array' => array_map(fn($childNode) => self::transformNode($childNode), (array) $node['value']),
            default => self::strrev(strval($node['value']))
        };

        return $node;
    }

    private static function strrev(string $str): string
    {
        $str = str_replace('{}', '', $str);
        $parts = explode('}', $str);
        if (count($parts) > 1) {
            return $parts[0].'}'.strrev($parts[1]);
        }
        return strrev($str);
    }

}
