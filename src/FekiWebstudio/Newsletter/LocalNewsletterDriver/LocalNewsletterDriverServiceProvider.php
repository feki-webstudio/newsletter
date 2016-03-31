<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 10:18
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use FekiWebstudio\Newsletter\Contracts\CampaignRepositoryContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberListRepositoryContract;
use Illuminate\Support\ServiceProvider;

class LocalNewsletterDriverServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind subscriber list repository
        $this->app->bind(
            SubscriberListRepositoryContract::class,
            SubscriberListRepository::class
        );

        // Bind campaign list repository
        $this->app->bind(
            CampaignRepositoryContract::class,
            CampaignRepository::class
        );
    }
}