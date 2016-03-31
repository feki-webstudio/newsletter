<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 10:05
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use FekiWebstudio\Newsletter\Contracts\SubscriberContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberListContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberListRepositoryContract;

class SubscriberListRepository implements SubscriberListRepositoryContract
{
    /**
     * Gets all subscriber lists with optional limits.
     *
     * @param int $offset
     * @param int $limit
     * @return SubscriberContract[]
     */
    public function getSubscriberLists($offset = 0, $limit = 0)
    {
        $subscribers = Subscriber::skip($offset);

        if ($limit > 0) {
            $subscribers = $subscribers->take($limit);
        }

        return $subscribers->get();
    }

    /**
     * Gets a subscriber list identified by its identifier.
     *
     * @param mixed $identifier
     * @return SubscriberListContract
     */
    public function getSubscriberList($identifier)
    {
        return SubscriberList::find($identifier);
    }
}