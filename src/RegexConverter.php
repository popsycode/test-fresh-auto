<?php

declare(strict_types=1);

namespace App;

class RegexConverter extends AbstractXmlFileConverter
{


    public function __construct(string $inputFilePath, string $outputFilePath)
    {
        parent::__construct($inputFilePath, $outputFilePath);
    }


    public function convert(): RegexConverter
    {
        $data = file_get_contents($this->inputFilePath);
        //convert open tag names
        $data = preg_replace_callback(
            '/<([\d|\w]+)([\s]+[^>]+[\s]*)?>/s',
            function ($matches) {
                $strrev = strrev($matches[1]);
                $attributes = '';
                if(isset($matches[2])){
                    //convert attributes
                    $attributes = preg_replace_callback(
                        '/(\w+)="(\w+)"[\s]*/s',
                        function ($matches) {
                            return " ".strrev($matches[1]).'="'.strrev($matches[2]).'"';
                        },
                        $matches[2]
                    );
                }
                return "<{$strrev}{$attributes}>";
            },
            $data
        );
        //convert close tag names
        $data = preg_replace_callback(
            '/<\/([\d|\w]+)>/s',
            function ($matches) {
                $strrev = strrev($matches[1]);
                return "</{$strrev}>";
            },
            $data
        );
        //convert text content
        $data = preg_replace_callback(
            '/>([^<]*[^\s])</s',
            function ($matches) {
                $strrev = strrev($matches[1]);
                return ">{$strrev}<";
            },
            $data
        );
        file_put_contents($this->outputFilePath, $data);
        return $this;
    }

}
