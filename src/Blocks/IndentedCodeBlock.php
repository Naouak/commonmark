<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 02/09/2015
 * Time: 21:18
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class IndentedCodeBlock implements Block
{
    private $parser;
    private $lines;

    /**
     * IndentedCodeBlock constructor.
     */
    public function __construct(Parser $parser, $lines)
    {
        $this->parser = $parser;
        $this->lines = $lines;
    }

    public static function check(Parser $parser)
    {
        $lines = [];

        try{
            $line = $parser->peakAhead();
            while(preg_match("/^( {4}| *$)/", $line)){
                $parser->consumeLine();
                $lines[] = $line;
                $line = $parser->peakAhead();
            }
        } catch( \OutOfRangeException $ignored){};


        if($lines){
            return new IndentedCodeBlock($parser, $lines);
        }

        return null;
    }

    public function render()
    {
        $lines = array_map(function($line){
            return htmlentities(substr($line, 4));
        }, $this->lines);

        while($lines[0] == ""){
            $lines = array_slice($lines,1);
        }

        while(end($lines) == ""){
            array_pop($lines);
        }

        return "<pre><code>".implode("\n", $lines)."\n</code></pre>";
    }
}