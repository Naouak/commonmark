<?php

/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 02/09/2015
 * Time: 20:43
 */
class SetextHeaderBlockTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown, $render)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\SetextHeaderBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");

        $this->assertEquals($render, $block->render());
    }

    /**
     * @dataProvider invalidRuleBlockProvider
     */
    public function testInvalidBlock($markdown){
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\SetextHeaderBlock::check($parser);
        $this->assertNull($block, "'$markdown' recognized");
    }

    public function ruleBlockProvider(){
        return [
            ["Foo *bar*
=========", "<h1>Foo <em>bar</em></h1>"],
            ["Foo *bar*
---------", "<h2>Foo <em>bar</em></h2>"],
            ["Foo
-------------------------", "<h2>Foo</h2>"],
            ["Foo
=", "<h1>Foo</h1>"],
            ["   Foo
---", "<h2>Foo</h2>"],
            ["  Foo
-----", "<h2>Foo</h2>"],
            ["  Foo
  ===", "<h1>Foo</h1>"],
            ["Foo
   ----      ", "<h2>Foo</h2>"],
            ["Foo
-----", "<h2>Foo</h2>"],
            ["Foo\\
----", "<h2>Foo\\</h2>"],
            ["\> foo
------", "<h2>&gt; foo</h2>"]
        ];
    }

    public function invalidRuleBlockProvider(){
        return [
            ["    Foo
    ---"],
            ["    Foo
---"],
            ["Foo
    ---"],
            ["Foo
= ="],
            ["Foo
--- -"],
            ["
===="]
        ];
    }
}
