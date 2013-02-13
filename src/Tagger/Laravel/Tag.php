<?php namespace Tagger\Laravel;

class Tag extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'tagger'; }

}
