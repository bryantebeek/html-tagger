<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;
use Request;

class Style extends Tag
{
    public function __construct($src = null)
    {
        $this->identifier = 'link';
        $this->setAttribute('type', 'text/css');
        $this->setAttribute('href', Request::root()."/".$src);
        $this->setAttribute('rel', 'stylesheet');
        $this->setAttribute('media', 'screen');
    }
}
