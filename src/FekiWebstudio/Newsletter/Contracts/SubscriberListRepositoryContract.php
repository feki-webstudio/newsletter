<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 9:29
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\Contracts;


/**
 * Interface SubscriberListRepositoryContract defines an interface
 * for subscriber list repositories.
 *
 * @package FekiWebstudio\Newsletter\Contracts
 */
interface SubscriberListRepositoryContract
{
    /**
     * Gets a subscriber list identified by its identifier.
     *
     * @param mixed $identifier
     * @return SubscriberListContract
     */
    public function getSubscriberList($identifier);
    
    /**
     * Gets all subscriber lists with optional limits.
     *
     * @param int $offset
     * @param int $limit
     * @return SubscriberContract[]
     */
    public function getSubscriberLists($offset = 0, $limit = 0);
}
