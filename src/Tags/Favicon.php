<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;
use Request;

class Favicon extends Tag
{
    public function __construct($link = null)
    {
        $this->identifier = 'link';
        $this->setAttribute('rel', 'shortcut icon');
        $this->setAttribute('type', 'image/x-icon');
        $this->setAttribute('href', Request::root().'/'.$link);
    }
}