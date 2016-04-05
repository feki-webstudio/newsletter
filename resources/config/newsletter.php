<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 10:12
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

return [
    'local-driver' => [
        'subscriber-type' => FekiWebstudio\Newsletter\LocalNewsletterDriver\Subscriber::class,
        'subscriber-list-type' => FekiWebstudio\Newsletter\LocalNewsletterDriver\SubscriberList::class,
        'campaign-type' => FekiWebstudio\Newsletter\LocalNewsletterDriver\Campaign::class,

        'confirmation-route' => 'newsletter.confirmation',
        'cancellation-route' => 'newsletter.cancel'
    ]
];
