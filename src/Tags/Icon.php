<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;
use URL;

class Icon extends Tag
{
	public function __construct($icon) {
        $this->identifier = 'i';
		$this->class('icon-'.$icon);
	}
}
