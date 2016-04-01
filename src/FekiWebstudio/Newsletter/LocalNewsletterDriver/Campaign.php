<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 14:39
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use DateTime;
use FekiWebstudio\Newsletter\Contracts\CampaignContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberContract;
use FekiWebstudio\Newsletter\Contracts\SubscriberListContract;
use Illuminate\Database\Eloquent\Model;
use Mail;

class Campaign extends Model implements CampaignContract
{
    /**
     * Sets the subject of the campaign.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->setAttribute($this->getSubjectAttributeName(), $subject);
    }

    /**
     * Gets the name of the subject attribute.
     *
     * @return string
     */
    protected function getSubjectAttributeName()
    {
        return 'subject';
    }

    /**
     * Gets the date the campaign should be sent at.
     *
     * @return DateTime
     */
    public function getSendAt()
    {
        return $this->getAttributeValue($this->getSendAtAttributeName());
    }

    /**
     * Gets the name of the send_at attribute.
     *
     * @return string
     */
    protected function getSendAtAttributeName()
    {
        return 'send_at';
    }

    /**
     * Sets the date the campaign should be sent at.
     *
     * @param DateTime $date
     */
    public function setSendAt(DateTime $date)
    {
        $this->setAttribute($this->getSendAtAttributeName(), $date);
    }

    /**
     * Sets the content of the campaign.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->setAttribute($this->getContentAttributeName(), $content);
    }

    /**
     * Gets the name of the content attribute.
     *
     * @return string
     */
    protected function getContentAttributeName()
    {
        return 'content';
    }

    /**
     * Sends the campaign immediately to a given list
     * of subscribers.
     *
     * @param SubscriberListContract $subscriberList
     * @return bool
     */
    public function send(SubscriberListContract $subscriberList)
    {
        $content = $this->getContent();

        // Number of recipients
        $numberOfRecipients = 0;

        // Simply run a foreach and send to all recipients one by one
        foreach ($subscriberList->getSubscribers(0, 99999) as $subscriber) {
            // Customize the content for the user (map attributes to values)
            $customContent = $this->mapFieldsToValues($content, $subscriber);

            // Send the mail
            Mail::send('newsletter::emails.newsletter', [
                'content' => $customContent,
                'subscriber' => $subscriber,
            ], function ($message) use ($subscriber) {
                $message->to($subscriber->getEmail());
                $message->subject($this->getSubject());
            });

            $numberOfRecipients++;
        }

        $this->setSentAt(new DateTime());
        $this->setNumberOfRecipients($numberOfRecipients);
        $this->save();
    }

    /**
     * Gets the content of the campaign.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getAttributeValue($this->getContentAttributeName());
    }

    /**
     * Maps the field placeholders to field values.
     *
     * @param string $content
     * @param SubscriberContract $subscriber ;
     * @return string
     */
    protected function mapFieldsToValues($content, $subscriber)
    {
        // Define tag pattern
        $pattern = $this->getFieldPattern();

        // Get all fields to be replaced
        preg_match_all($pattern, $content, $fields);

        if (! array_key_exists('tag', $fields)) {
            // No tag to be replaced
            return $content;
        }

        // Replace all tags
        foreach ($fields['tag'] as $field) {
            $tagMask = $this->getFieldMask($field);
            $content = str_replace_array($tagMask, $subscriber->getField($field), $content);
        }

        return $content;
    }

    /**
     * Gets the pattern used for fields to be mapped.
     *
     * @return string
     */
    protected function getFieldPattern()
    {
        return '~\*\|(?<tag>[a-zA-Z0-9]+)\|\*~';
    }

    /**
     * Gets the mask to be replaced.
     *
     * @param string $field
     * @return string
     */
    protected function getFieldMask($field)
    {
        return '*|' . strtoupper($field) . '|*';
    }

    /**
     * Gets the subject of the campaign.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->getAttributeValue($this->getSubjectAttributeName());
    }

    /**
     * Sets the sent_at attribute.
     *
     * @param DateTime $date
     */
    protected function setSentAt(DateTime $date)
    {
        $this->setAttribute($this->getSentAtAttributeName(), $date->getTimestamp());
    }

    /**
     * Gets the name of the sent_at attribute.
     *
     * @return string
     */
    protected function getSentAtAttributeName()
    {
        return 'sent_at';
    }

    /**
     * Sets the number of the recipients.
     *
     * @param int $count
     */
    protected function setNumberOfRecipients($count)
    {
        $this->setAttribute($this->getNumberOfRecipientsAttributeName(), $count);
    }

    /**
     * Gets the name of the "number of recipients" attribute.
     *
     * @return string
     */
    protected function getNumberOfRecipientsAttributeName()
    {
        return 'recipient_count';
    }

    /**
     * Gets the date the campaign has been sent at.
     * Returns null if the campaign has not been sent yet.
     *
     * @return DateTime|null
     */
    public function getSentAt()
    {
        return $this->getAttribute($this->getSentAtAttributeName());
    }

    /**
     * Gets the list of the recipients the campaign
     * has been sent to .
     *
     * @return SubscriberContract[]
     */
    public function getRecipients()
    {
        throw new \BadMethodCallException('Basic implementation of the LocalNewsletterDriver does not implement getRecipients() method. Make sure to override it.');
    }

    /**
     * Gets the number of the recipients.
     *
     * @return int
     */
    public function numberOfRecipients()
    {
        return $this->getAttributeValue($this->getNumberOfRecipientsAttributeName());
    }

    /**
     * Gets the subscriber list relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriberList()
    {
        return $this->belongsTo(SubscriberList::class);
    }
}