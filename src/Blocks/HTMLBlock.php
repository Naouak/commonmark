<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 06/09/2015
 * Time: 18:56
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

class HTMLBlock implements Block
{
    private $lines = [];
    
    /**
     * HTMLBlock constructor.
     */
    public function __construct(Parser $parser, $lines)
    {
        $this->lines = $lines;
    }

    public static function check(Parser $parser)
    {
        $line = $parser->peakAhead();
        //Type 1 HTML Block : Code
        if(preg_match("/^ {0,3}<(script|pre|style)( |>|$)/i",$line, $matches)){
            $lines = [];
            $tag = $matches[0];
            try{
                while(!preg_match("/</$tag>/i", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 2 HTML Block : comment
        if(preg_match("/^ {0,3}<!--/", $line)){
            $lines = [];
            try{
                while(!preg_match("/-->/", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 3 HTML Block : instructions
        if(preg_match("/^ {0,3}<\?/", $line)){
            $lines = [];
            try{
                while(!preg_match("/\?>/", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 4 HTML Block
        if(preg_match("/^ {0,3}<![A-Z]/", $line)){
            $lines = [];
            try{
                while(!preg_match("/>/", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 5 HTML Block : CDATA
        if(preg_match("/^ {0,3}<!\[CDATA\[/", $line)){
            $lines = [];
            try{
                while(!preg_match("/\]\]>/", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 6 HTML Block : garbage
        $tags = [
            "address", "article", "aside", "base", "basefont", "blockquote", "body", "caption", "center", "col",
            "colgroup", "dd", "details", "dialog", "dir", "div", "dl", "dt", "fieldset", "figcaption", "figure",
            "footer", "form", "frame", "frameset", "h1", "head", "header", "hr", "html", "iframe", "legend", "li",
            "link", "main", "menu", "menuitem", "meta", "nav", "noframes", "ol", "optgroup", "option", "p", "param",
            "section", "source", "summary", "table", "tbody", "td", "tfoot", "th", "thead", "title", "tr", "track",
            "ul"
        ];
        if(preg_match("/^ {0,3}</?(".implode("|",$tags).")( |$|>|/>)/", $line)){
            $lines = [];
            try{
                while(!preg_match("/^ *$/", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        //Type 7 HTML Block : Any tag
        //Hell's regex, I broke it down in several parts for it to be readable a bit.
        $tagname = "[A-z][A-z0-9-]*";
        $attrib_name = "[A-z_:][A-z0-9_\.:-]*";
        $attrib_value = "[^\"'=<>` ]+";
        $single_quoted_attrib_value = "'[^']*'";
        $double_quoted_attrib_value = "\"[^\"]*\"";
        $attributes = " +$attrib_name( *= *($attrib_value|$single_quoted_attrib_value|$double_quoted_attrib_value))?";
        $opening_tag = "<($tagname)($attributes)* *( |/?>|$)";
        $closing_tag = "</$tagname *>";
        if(preg_match("/^ {0,3}($opening_tag|$closing_tag)/i",$line, $matches)){
            $lines = [];
            try{
                while(!preg_match("/^ *$/i", $line)){
                    $parser->consumeLine();
                    $lines[] = $line;
                    $line = $parser->peakAhead();
                }
            } catch(\OutOfRangeException $ignored){}

            $parser->consumeLine();
            $lines[] = $line;

            return new HTMLBlock($parser, $lines);
        }

        return null;
    }

    public function render()
    {
        return implode("\n", $this->lines)."\n";
    }
}