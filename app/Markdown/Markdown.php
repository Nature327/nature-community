<?php
/**
 * Created by PhpStorm.
 * User: Nature
 * Date: 2017/6/13
 * Time: 15:14
 */

namespace App\Markdown;


class Markdown
{
    protected $parser;
    function __construct(Parser $parser)
    {
     $this->parser = $parser;
    }

    public function markdown($text)
    {
        $html = $this->parser->makeHtml($text);
        return $html;
    }
}