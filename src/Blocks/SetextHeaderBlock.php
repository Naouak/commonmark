<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 02/09/2015
 * Time: 20:42
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class SetextHeaderBlock implements Block
{
    private $parser;
    private $title;
    private $underline;


    /**
     * SetextHeaderBlock constructor.
     */
    public function __construct(Parser $parser, $title, $underline)
    {
        $this->parser = $parser;
        $this->title = $title;
        $this->underline = $underline;
    }

    public static function check(Parser $parser)
    {
        $title = $parser->consumeLine();
        $underline = $parser->consumeLine();

        if(preg_match("/^( {4}| *$)/", $title)){
            return null;
        }

        if(preg_match("/^ {0,3}(-+|=+) *$/", $underline)){
            return new SetextHeaderBlock($parser,$title,$underline);
        }
        return null;
    }

    public function render()
    {
        $titleLevel = 1;
        if(strpos($this->underline,"-") !== false){
            $titleLevel = 2;
        }

        $title = trim($this->title);

        return "<h$titleLevel>$title</h$titleLevel>";
    }
}