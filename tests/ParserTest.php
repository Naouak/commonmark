<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 20:52
 */

namespace Naouak\Commonmark\Tests;


use Naouak\Commonmark\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testLines(){
        $parser = new Parser("Test\nTest");
        $this->assertEquals(count($parser->getLines()),2);

        $parser = new Parser("Test\r\nTest");
        $this->assertEquals(count($parser->getLines()),2);

        $parser = new Parser("Test\nTest\r\nTest");
        $this->assertEquals(count($parser->getLines()),3);
    }
}
