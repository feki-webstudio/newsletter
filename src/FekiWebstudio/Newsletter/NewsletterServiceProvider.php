<?php
namespace FekiWebstudio\Newsletter;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load vendor views
        $this->loadViewsFrom(__DIR__ . '/../../../resources/views', 'newsletter');
        
        // Publish config
        $this->publishes([
            __DIR__ . '/../../../config/newsletter.php' => config_path('newsletter.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // Merge default config file
        $this->mergeConfigFrom(
            __DIR__  . '/../../../resources/config/newsletter.php',
            'newsletter'
        );
    }
}
