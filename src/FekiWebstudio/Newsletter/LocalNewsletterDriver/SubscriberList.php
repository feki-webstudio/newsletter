<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 14:22
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use FekiWebstudio\Newsletter\Contracts\SubscriberContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberListContract;
use Illuminate\Database\Eloquent\Model;

class SubscriberList extends Model implements SubscriberListContract
{
    /**
     * Gets the subscriber relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    /**
     * Subscribes a user to the subscriber list.
     *
     * @param SubscriberContract $subscriber
     * @param bool
     */
    public function subscribe(SubscriberContract $subscriber)
    {
        $this->subscribers()->create($subscriber);
    }

    /**
     * Unsubscribes a user from the subscriber list.
     *
     * @param SubscriberContract $subscriber
     * @return bool
     */
    public function unsubscribe(SubscriberContract $subscriber)
    {
        /** @var Subscriber $subscriber */
        $subscriber = $this->subscribers()->find($subscriber->getKey());

        if (! is_null($subscriber)) {
            return $subscriber->delete();
        }

        return false;
    }

    /**
     * Gets the list of the subscribers of the list.
     *
     * @param int $offset
     * @param int $limit
     * @return SubscriberContract[]
     */
    public function getSubscribers($offset = 0, $limit = 0)
    {
        $subscribers = $this->subscribers()->skip($offset);

        if ($limit > 0) {
            $subscribers = $subscribers->take($limit);
        }

        return $subscribers->get();
    }
}