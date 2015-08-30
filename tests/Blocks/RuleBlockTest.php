<?php

/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 22:19
 */
class RuleBlockTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\RuleBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");
    }

    /**
     * @dataProvider invalidRuleBlockProvider
     */
    public function testInvalidBlock($markdown){
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\RuleBlock::check($parser);
        $this->assertNull($block, "'$markdown' recognized");
    }

    public function ruleBlockProvider(){
        return [
            ["***"],
            ["---"],
            ["___"],
            [" ***"],
            ["  ***"],
            ["   ***"],
            ["_____________________________________"],
            [" - - -"],
            [" **  * ** * ** * **"],
            ["-     -      -      -"],
            ["- - - -    "]
        ];
    }

    public function invalidRuleBlockProvider(){
        return [
            ["+++"],
            ["==="],
            ["--"],
            ["**"],
            ["__"],
            ["    ***"],
            ["_ _ _ _ a"],
            ["a------"],
            ["---a---"],
            [" *-*"]
        ];
    }
}
