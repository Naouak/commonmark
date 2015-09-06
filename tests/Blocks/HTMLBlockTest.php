<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 06/09/2015
 * Time: 20:27
 */

namespace Naouak\Commonmark\Tests\Blocks;


class HTMLBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ruleBlockProvider
     */
    public function testBlock($markdown, $render)
    {
        $parser = new \Naouak\Commonmark\Parser($markdown);
        $block = \Naouak\Commonmark\Blocks\HTMLBlock::check($parser);
        $this->assertNotNull($block, "'$markdown' not recognized");

        $this->assertEquals($render, $block->render());
    }

    public function ruleBlockProvider(){
        return [
            ["<table>\n  <tr>\n    <td>\n           hi\n    </td>\n  </tr>\n</table>\n","<table>\n  <tr>\n    <td>\n           hi\n    </td>\n  </tr>\n</table>"],
            [" <div>\n  *hello*\n         <foo><a>"," <div>\n  *hello*\n         <foo><a>"],
            ["</div>\n*foo*","</div>\n*foo*"],
            ["<div id=\"foo\"\n  class=\"bar\">\n</div>","<div id=\"foo\"\n  class=\"bar\">\n</div>"],
            ["<div id=\"foo\" class=\"bar\n  baz\">\n</div>","<div id=\"foo\" class=\"bar\n  baz\">\n</div>"],
            ["<div id=\"foo\"\n*hi*", "<div id=\"foo\"\n*hi*"],
            ["<div class\nfoo","<div class\nfoo"],
            ["<div *???-&&&-<---\n*foo*", "<div *???-&&&-<---\n*foo*"],
            ["<div><a href=\"bar\">*foo*</a></div>","<div><a href=\"bar\">*foo*</a></div>"],
            ["<table><tr><td>\nfoo\n</td></tr></table>","<table><tr><td>\nfoo\n</td></tr></table>"],
            ["<div></div>\n``` c\nint x = 33;\n```","<div></div>\n``` c\nint x = 33;\n```"],
            ["<a href=\"foo\">\n*bar*\n</a>","<a href=\"foo\">\n*bar*\n</a>"],
            ["<Warning>\n*bar*\n</Warning>","<Warning>\n*bar*\n</Warning>"],
            ["<i class=\"foo\">\n*bar*\n</i>","<i class=\"foo\">\n*bar*\n</i>"],
            ["</ins>\n*bar*","</ins>\n*bar*"],
            ["<del>\n*foo*\n</del>","<del>\n*foo*\n</del>"],
            ["<pre language=\"haskell\"><code>\nimport Text.HTML.TagSoup\n\nmain :: IO ()\nmain = print $ parseTags tags\n</code></pre>","<pre language=\"haskell\"><code>\nimport Text.HTML.TagSoup\n\nmain :: IO ()\nmain = print $ parseTags tags\n</code></pre>"],
            ["<script type=\"text/javascript\">\n// JavaScript example\n\ndocument.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";\n</script>","<script type=\"text/javascript\">\n// JavaScript example\n\ndocument.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";\n</script>"],
            ["<style\n  type=\"text/css\">\nh1 {color:red;}\n\np {color:blue;}\n</style>","<style\n  type=\"text/css\">\nh1 {color:red;}\n\np {color:blue;}\n</style>"],
            ["<style\n  type=\"text/css\">\n\nfoo","<style\n  type=\"text/css\">\n\nfoo"],
            ["<style>p{color:red;}</style>","<style>p{color:red;}</style>"],
            ["<!-- foo -->*bar*","<!-- foo -->*bar*"],
            ["<script>\nfoo\n</script>1. *bar*","<script>\nfoo\n</script>1. *bar*"],
            ["<!-- Foo\n\nbar\n   baz -->","<!-- Foo\n\nbar\n   baz -->"],
            ["<?php\n\n  echo '>';\n\n?>","<?php\n\n  echo '>';\n\n?>"],
            ["<!DOCTYPE html>","<!DOCTYPE html>"],
            ["<![CDATA[\nfunction matchwo(a,b)\n{\n  if (a < b && a < 0) then {\n    return 1;\n\n  } else {\n\n    return 0;\n  }\n}\n]]>","<![CDATA[\nfunction matchwo(a,b)\n{\n  if (a < b && a < 0) then {\n    return 1;\n\n  } else {\n\n    return 0;\n  }\n}\n]]>"],
            ["  <!-- foo -->","  <!-- foo -->"]
        ];
    }
}
