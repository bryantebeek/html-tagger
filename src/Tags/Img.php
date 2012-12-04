<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;
use Request;

class Img extends Tag
{
	public function __construct($path = null) {
		$this->src($path);
	}

	public function src($path)
	{
        if(strpos($path, 'http://') !== false)
        {
            return $this->setAttribute('src', $path);
        }

		return $this->setAttribute('src', Request::root()."/".$path);
	}
}
