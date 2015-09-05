<?php
/**
 * Created by PhpStorm.
 * User: Naouak
 * Date: 30/08/2015
 * Time: 20:27
 */

namespace Naouak\Commonmark;


class Parser
{
    private $markdown_string;
    private $lines = [];
    private $stack = [0];

    /**
     * Parser constructor.
     * @param $markdown_string String to parse
     */
    public function __construct($markdown_string)
    {
        $this->markdown_string = $markdown_string;

        // Remove unwanted characters according to Spec
        $this->sanitize();

        // Divide the markdown into lines to look for blocks
        $this->divideLines();
    }

    private function sanitize(){
        $this->markdown_string = str_replace("\x00\x00","\xff\xfd",$this->markdown_string);
    }

    private function divideLines(){
        $this->lines = preg_split("/(\n|\r\n|\r)/", $this->markdown_string);
    }

    public function getLines(){
        return $this->lines;
    }

    /**
     * Return next line without advancing the stack
     * @return mixed
     */
    public function peakAhead(){
        if(end($this->stack) < count($this->lines)){
            return $this->lines[end($this->stack)];
        } else {
            throw new \OutOfRangeException();
        }
    }

    /**
     * Return next line in stack
     * @return mixed
     */
    public function consumeLine(){
        if(end($this->stack) >= count($this->lines)){
            throw new \OutOfRangeException();
        }
        $line = $this->lines[end($this->stack)];
        $this->advanceStack();
        return $line;
    }

    /**
     * Advance parser top stack position
     */
    private function advanceStack(){
        $this->stack[count($this->stack)-1]++;
    }
}