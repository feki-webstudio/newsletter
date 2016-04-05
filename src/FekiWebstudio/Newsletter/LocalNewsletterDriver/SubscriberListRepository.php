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
     * Type of the subscriber list object.
     *
     * @var string
     */
    protected $subscriberListType;

    /**
     * Type of the subscriber object.
     *
     * @var string
     */
    protected $subscriberType;

    /**
     * SubscriberListRepository constructor.
     */
    public function __construct()
    {
        $this->subscriberType = config('newsletter.local-driver.subscriber-type');
        $this->subscriberListType = config('newsletter.local-driver.subscriber-list-type');
    }

    /**
     * Gets all subscriber lists with optional limits.
     *
     * @param int $offset
     * @param int $limit
     * @return SubscriberContract[]
     */
    public function getSubscriberLists($offset = 0, $limit = 0)
    {
        if (! $limit) {
            return $this->callStaticMethod($this->subscriberListType, 'get');
        }

        $subscribers = $this->callStaticMethod($this->subscriberListType, 'skip', $offset);
        $subscribers = $subscribers->take($limit);
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
        return $this->callStaticMethod($this->subscriberListType, 'find', $identifier);
    }

    /**
     * Calls a static method of an object with the given type.
     *
     * @param string $type
     * @param string $method
     * @param mixed $params
     * @return mixed
     */
    protected function callStaticMethod($type, $method, $params = null)
    {
        return call_user_func($type . "::" . $method, $params);
    }
}