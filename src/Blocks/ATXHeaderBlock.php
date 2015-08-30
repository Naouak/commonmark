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
    private $parser;
    private $line;
    
    /**
     * ATXHeaderBlock constructor.
     */
    private function __construct(Parser $parser, $line)
    {
        $this->parser = $parser;
        $this->line = trim($line);
    }

    public static function check(Parser $parser)
    {
        $line = $parser->consumeLine();

        if(preg_match("/^( ){0,3}#{1,6}( |$)/", $line)){
            return new ATXHeaderBlock($parser, $line);
        }

        return null;
    }


    public function render()
    {
        preg_match("/^ {0,3}(#{1,6})(.*)$/", $this->line, $matches);
        $title_level = strlen($matches[1]);

        // Remove optional end of line
        $content = preg_replace("/ +#* *$/","", $matches[2]);
        $content = trim($content);

        //@Todo Inline Parse of Content

        return "<h$title_level>$content</h$title_level>";

    }
}