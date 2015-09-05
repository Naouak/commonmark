<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 05/09/2015
 * Time: 22:37
 */

namespace Naouak\Commonmark\Tests\Blocks;


class FencedCodeBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown, $render)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\FencedCodeBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");

        $this->assertEquals($render, $block->render(), "Difference in '$markdown'");
    }

    /**
     * @dataProvider invalidRuleBlockProvider
     */
    public function testInvalidBlock($markdown){
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\FencedCodeBlock::check($parser);
        $this->assertNull($block, "'$markdown' recognized");
    }

    public function ruleBlockProvider(){
        return [
            ["```\n<\n >\n```", "<pre><code>&lt;\n &gt;\n</code></pre>"],
            ["~~~\n<\n >\n~~~", "<pre><code>&lt;\n &gt;\n</code></pre>"],
            ["```\naaa\n~~~\n```", "<pre><code>aaa\n~~~\n</code></pre>"],
            ["~~~\naaa\n```\n~~~", "<pre><code>aaa\n```\n</code></pre>"],
            ["````\naaa\n```\n``````", "<pre><code>aaa\n```\n</code></pre>"],
            ["~~~~\naaa\n~~~\n~~~~", "<pre><code>aaa\n~~~\n</code></pre>"],
            ["```", "<pre><code></code></pre>"],
            ["`````\n\n```\naaa", "<pre><code>\n```\naaa\n</code></pre>"],
            ["```\n\n  \n```", "<pre><code>\n  \n</code></pre>"],
            ["```\n```", "<pre><code></code></pre>"],
            [" ```\n aaa\naaa\n```", "<pre><code>aaa\naaa\n</code></pre>"],
            ["  ```\naaa\n  aaa\naaa\n  ```", "<pre><code>aaa\naaa\naaa\n</code></pre>"],
            ["   ```\n   aaa\n    aaa\n  aaa\n   ```", "<pre><code>aaa\n aaa\naaa\n</code></pre>"],
            ["```\naaa\n  ```", "<pre><code>aaa\n</code></pre>"],
            ["   ```\naaa\n  ```", "<pre><code>aaa\n</code></pre>"],
            ["```\naaa\n    ```", "<pre><code>aaa\n    ```\n</code></pre>"],
            ["~~~~~~\naaa\n~~~ ~~", "<pre><code>aaa\n~~~ ~~\n</code></pre>"],
            ["```ruby\ndef foo(x)\n  return 3\nend\n```",
                "<pre><code class=\"language-ruby\">def foo(x)\n  return 3\nend\n</code></pre>"],
            ["~~~~    ruby startline=3 $%@#$\ndef foo(x)\n  return 3\nend\n~~~~~~~",
                "<pre><code class=\"language-ruby\">def foo(x)\n  return 3\nend\n</code></pre>"],
            ["````;\n````", "<pre><code class=\"language-;\"></code></pre>"],
            ["```\n``` aaa\n```", "<pre><code>``` aaa\n</code></pre>"]
        ];
    }

    public function invalidRuleBlockProvider(){
        return [
            ["``` ```\naaa"],
            ["``` aa ```\nfoo"]
        ];
    }
}
