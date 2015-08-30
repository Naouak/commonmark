<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 22:34
 */

namespace Naouak\Commonmark\Blocks;


use Naouak\Commonmark\Parser;

interface Block
{
    public static function check(Parser $parser);
    public function render();
}