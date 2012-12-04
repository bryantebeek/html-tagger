<?php namespace Goforit\Doit\Tag;

use Goforit\Doit\Tag;
use URL;

class A extends Tag
{
	public function __construct($link = null) {
		$this->href($link);
	}

	public function href($link)
	{
		if(strpos($link, '@') !== false) {
			return $this->setAttribute('href', URL::action($link));
		}

		return $this->setAttribute('href', $link);
	}
}