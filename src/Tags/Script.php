<?php namespace Goforit\Doit\Tag;

use Tag, Request;

class Script extends Tag
{
    public function __construct($src = null)
    {
        $this->setAttribute('type', 'text/javascript');
        $this->setAttribute('src', Request::root().'/'.$src);
    }
}
