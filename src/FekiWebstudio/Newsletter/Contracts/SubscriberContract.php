<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 13:25
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\Contracts;

/**
 * Interface SubscriberContract defines an interface
 * for newsletter subscribers.
 *
 * @package FekiWebstudio\Newsletter\Contracts
 */
interface SubscriberContract
{
    /**
     * Gets the e-mail address of the subscriber.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets the e-mail address of the subscriber.
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Gets a custom field (like name) of the subscriber.
     *
     * @param string $fieldName
     * @return mixed
     */
    public function getField($fieldName);

    /**
     * Sets the value of a custom field of the subscriber.
     *
     * @param string $fieldName
     * @param mixed $fieldValue
     */
    public function setField($fieldName, $fieldValue);
}