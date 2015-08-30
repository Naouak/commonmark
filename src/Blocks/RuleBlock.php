<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 22:04
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class RuleBlock implements Block
{
    public static function check(Parser $parser){
        $line = $parser->consumeLine();
        if(
            preg_match("/^( |\t){0,3}\*( |\t)*\*( |\t)*\*( |\t|\*)*$/", $line)
            ||
            preg_match("/^( |\t){0,3}-( |\t)*-( |\t)*-( |\t|\-)*$/", $line)
            ||
            preg_match("/^( |\t){0,3}_( |\t)*_( |\t)*_( |\t|_)*$/", $line)
        ){
            return new RuleBlock($parser, $line);
        }

        return null;
    }

    /**
     * RuleBlock constructor
     */
    public function __construct(Parser $parser, $line)
    {

    }

    public function render(){
        return "<hr />";
    }
}