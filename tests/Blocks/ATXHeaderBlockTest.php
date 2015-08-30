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
    public function testBlock($markdown, $render)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\ATXHeaderBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");

        $this->assertEquals($render, $block->render());
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
            ["# foo", "<h1>foo</h1>"],
            ["## foo", "<h2>foo</h2>"],
            ["### foo", "<h3>foo</h3>"],
            ["#### foo", "<h4>foo</h4>"],
            ["##### foo", "<h5>foo</h5>"],
            ["###### foo", "<h6>foo</h6>"],
            ["# foo *bar* \\*baz\\*", "<h1>foo <em>bar</em> *baz*</h1>"],
            ["#                  foo                     ", "<h1>foo</h1>"],
            [" ### foo", "<h3>foo</h3>"],
            ["  ## foo", "<h2>foo</h2>"],
            ["   # foo", "<h1>foo</h1>"],
            ["## foo ##", "<h2>foo</h2>"],
            ["  ###   bar    ###", "<h3>bar</h3>"],
            ["# foo ##################################", "<h1>foo</h1>"],
            ["##### foo ##", "<h5>foo</h5>"],
            ["### foo ###     ", "<h3>foo</h3>"],
            ["### foo ### b", "<h3>foo ### b</h3>"],
            ["# foo#", "<h1>foo#</h1>"],
            ["### foo \\###", "<h3>foo ###</h3>"],
            ["## foo #\\##", "<h2>foo ###</h2>"],
            ["# foo \\#", "<h1>foo #</h1>"],
            ["## ", "<h2></h2>"],
            ["#", "<h1></h1>"],
            ["### ###", "<h3></h3>"]
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
