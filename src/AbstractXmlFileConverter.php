<?php

declare(strict_types=1);

namespace App;

abstract class AbstractXmlFileConverter implements IXmlFileConverter
{
    protected string $inputFilePath;
    protected string $outputFilePath;

    public function __construct(string $inputFilePath, string $outputFilePath)
    {
        $this->inputFilePath = $inputFilePath;
        $this->outputFilePath = $outputFilePath;
    }
}
