<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 22:37
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class ATXHeaderBlock implements Block
{
    
    /**
     * ATXHeaderBlock constructor.
     */
    public function __construct(Parser $parser, $line)
    {
    }

    public static function check(Parser $parser)
    {
        $line = $parser->consumeLine();

        if(preg_match("/^( ){0,3}#{1,6}( |$)/", $line)){
            return new ATXHeaderBlock($parser, $line);
        }

        return null;
    }


}