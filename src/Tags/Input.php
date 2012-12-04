<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;

class Input extends Tag
{
	public function __construct($type = null) {
		$this->type($type);
	}

	public function type($type)
	{
		return $this->setAttribute('type', $type);
	}
}