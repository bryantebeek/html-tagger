<?php namespace Tagger\Laravel;

use Illuminate\Support\ServiceProvider;
use Tagger\Tag;

class TaggerServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['tagger'] = $this->app->share(function($app)
        {
            return new Tag;
        });
    }

}
