<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 20:25
 */

namespace Naouak\Commonmark;


class Converter
{
    /**
     * Convert a markdown string into HTML
     *
     * @param $markdown_string string Markdown string to convert
     * @return string
     */
    public function convert($markdown_string){
        $parser = new Parser($markdown_string);


    }
}