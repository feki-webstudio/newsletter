<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 13:28
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\Contracts;

/**
 * Interface SubscriberListContract defines an interface
 * for subscriber lists.
 *
 * @package FekiWebstudio\Newsletter\Contracts
 */
interface SubscriberListContract
{
    /**
     * Subscribes a user to the subscriber list.
     *
     * @param SubscriberContract $subscriber
     * @param bool
     */
    public function subscribe(SubscriberContract $subscriber);

    /**
     * Unsubscribes a user from the subscriber list.
     *
     * @param SubscriberContract $subscriber
     * @return bool
     */
    public function unsubscribe(SubscriberContract $subscriber);

    /**
     * Gets the (partial) list of the subscribers of the list.
     *
     * @param int $offset
     * @param int $limit
     * @return SubscriberContract[]
     */
    public function getSubscribers($offset = 0, $limit = 0);
}