<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 02/09/2015
 * Time: 21:18
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class FencedCodeBlock implements Block
{
    private $parser;
    private $lines;
    private $info;
    private $indent;

    /**
     * FencedCodeBlock constructor.
     */
    public function __construct(Parser $parser, $lines, $info, $indent)
    {
        $this->parser = $parser;
        $this->lines = $lines;
        $this->info = $info;
        $this->indent = $indent;


    }

    public static function check(Parser $parser)
    {
        $lines = [];

        $line = $parser->consumeLine();

        if(!preg_match("/^( *)(`{3,}|~{3,})([^`]*)$/", $line, $matches)){
            return null;
        }

        $separators = $matches[2];
        $infoString = $matches[3];
        $indent = strlen($matches[1]);

        $endregex = "/^ {0,3}".$separators[0]."{".strlen($separators).",} *$/";

        try{
            $line = $parser->consumeLine();
            while(!preg_match($endregex, $line)){
                $lines[] = $line;
                $line = $parser->consumeLine();
            }
        } catch( \OutOfRangeException $ignored){};

        return new FencedCodeBlock($parser, $lines, $infoString, $indent);
    }

    public function render()
    {
        $lines = array_map(function($line){
            return htmlentities(substr($line, min($this->indent, max(0,strlen($line) - strlen(ltrim($line))) )));
        }, $this->lines);

        $info = trim($this->info);
        if(strpos($info, " ")){
            $info = substr($info, 0, strpos($info, " "));
        }

        if(strlen($info) > 0){
            $info = " class=\"language-$info\"";
        }

        if(count($lines) == 0){
            return "<pre><code$info></code></pre>";
        }

        return "<pre><code$info>".implode("\n", $lines)."\n</code></pre>";
    }
}