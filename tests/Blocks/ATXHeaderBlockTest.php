<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 22:42
 */

namespace Naouak\Commonmark\Tests\Blocks;


class ATXHeaderBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\ATXHeaderBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");
    }

    /**
     * @dataProvider invalidRuleBlockProvider
     */
    public function testInvalidBlock($markdown){
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\ATXHeaderBlock::check($parser);
        $this->assertNull($block, "'$markdown' recognized");
    }

    public function ruleBlockProvider(){
        return [
            ["# foo"],
            ["## foo"],
            ["### foo"],
            ["#### foo"],
            ["##### foo"],
            ["###### foo"],
            ["# foo *bar* \*baz\*"],
            ["#                  foo                     "],
            [" ### foo"],
            ["  ## foo"],
            ["   # foo"],
            ["## foo ##"],
            ["  ###   bar    ###"],
            ["# foo ##################################"],
            ["##### foo ##"],
            ["### foo ###     "],
            ["### foo ### b"],
            ["# foo#"],
            ["### foo \\###"],
            ["## foo #\##"],
            ["# foo \#"],
            ["## "],
            ["#"],
            ["### ###"]
        ];
    }

    public function invalidRuleBlockProvider(){
        return [
            ["####### foo"],
            ["#5 bolt"],
            ["#foobar"],
            ["\\## foo"],
            ["    # foo"]
        ];
    }
}
