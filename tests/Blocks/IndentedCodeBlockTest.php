<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 02/09/2015
 * Time: 21:19
 */

namespace Naouak\Commonmark\Tests\Blocks;


class IndentedCodeBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown, $render)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\IndentedCodeBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");

        $this->assertEquals($render, $block->render());
    }

    /**
     * @dataProvider invalidRuleBlockProvider
     */
    public function testInvalidBlock($markdown){
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\IndentedCodeBlock::check($parser);
        $this->assertNull($block, "'$markdown' recognized");
    }

    public function ruleBlockProvider(){
        return [
            ["    a simple
      indented code block", "<pre><code>a simple
  indented code block
</code></pre>"],
            ["    <a/>
    *hi*

    - one", "<pre><code>&lt;a/&gt;
*hi*

- one
</code></pre>"],
            ["    chunk1

    chunk2



    chunk3", "<pre><code>chunk1

chunk2



chunk3
</code></pre>"],
            ["    chunk1

      chunk2", "<pre><code>chunk1

  chunk2
</code></pre>"],
            ["        foo
    bar", "<pre><code>    foo
bar
</code></pre>"],
            ["    foo

", "<pre><code>foo
</code></pre>"],
            ["    foo  ", "<pre><code>foo  \n</code></pre>"]
        ];
    }

    public function invalidRuleBlockProvider(){
        return [
            ["   a simple
      indented code block"]
        ];
    }
}
