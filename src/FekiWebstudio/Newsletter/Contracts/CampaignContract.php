<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 13:31
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\Contracts;

use \DateTime;

/**
 * Interface CampaignContract defines an interface
 * for newsletter campaigns.
 *
 * @package FekiWebstudio\Newsletter\Contracts
 */
interface CampaignContract
{
    /**
     * Gets the identifier of the contract.
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Gets the subject of the campaign.
     *
     * @return string
     */
    public function getSubject();

    /**
     * Sets the subject of the campaign.
     *
     * @param string $subject
     */
    public function setSubject($subject);

    /**
     * Gets the date the campaign should be sent at.
     *
     * @return DateTime
     */
    public function getSendAt();

    /**
     * Sets the date the campaign should be sent at.
     *
     * @param DateTime $date
     */
    public function setSendAt(DateTime $date);

    /**
     * Gets the content of the campaign.
     *
     * @return string
     */
    public function getContent();

    /**
     * Sets the content of the campaign.
     *
     * @param string $content
     */
    public function setContent($content);

    /**
     * Sends the campaign immediately to a given list
     * of subscribers.
     *
     * @param SubscriberListContract $subscriberList
     * @return bool
     */
    public function send(SubscriberListContract $subscriberList);

    /**
     * Gets the date the campaign has been sent at.
     * Returns null if the campaign has not been sent yet.
     *
     * @return DateTime|null
     */
    public function getSentAt();

    /**
     * Gets the list of the recipients the campaign
     * has been sent to .
     *
     * @return SubscriberContract[]
     */
    public function getRecipients();

    /**
     * Gets the number of the recipients.
     *
     * @return int
     */
    public function numberOfRecipients();
}