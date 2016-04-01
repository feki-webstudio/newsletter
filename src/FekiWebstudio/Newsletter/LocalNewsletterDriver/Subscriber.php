<?php
/**
 * Created by Feki Webstudio - 2016. 03. 30. 13:44
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use FekiWebstudio\Newsletter\Contracts\SubscriberContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Mail;
use Uuid;

class Subscriber extends Model implements SubscriberContract
{
    /**
     * Attributes that are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['_token', '_method'];

    /**
     * Gets the e-mail address of the subscriber.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getField($this->getEmailAttributeName());
    }

    /**
     * Sets the e-mail address of the subscriber.
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->setField($this->getEmailAttributeName(), $email);
    }

    /**
     * Gets a custom field (like name) of the subscriber.
     *
     * @param string $fieldName
     * @return mixed
     */
    public function getField($fieldName)
    {
        $fieldName = camel_case($fieldName);

        return $this->getAttributeValue($fieldName);
    }

    /**
     * Sets the value of a custom field of the subscriber.
     *
     * @param string $fieldName
     * @param mixed $fieldValue
     */
    public function setField($fieldName, $fieldValue)
    {
        $this->setAttribute(camel_case($fieldName), $fieldValue);
    }

    /**
     * Scopes the query to active subscribers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where(static::getIsActiveAttributeName(), '=', true);
    }

    /**
     * Scopes the query to subscribers having a specified unique id.
     *
     * @param Builder $query
     * @param string $uniqueId
     * @return Builder
     */
    public function scopeWhereUniqueId($query, $uniqueId)
    {
        return $query->where(
            static::getUniqueIdAttributeName(),
            '=',
            $uniqueId
        );
    }

    /**
     * Sends the activation e-mail to the subscriber.
     */
    public function sendActivationEmail()
    {
        // Set unique id
        $this->setRandomUniqueId();
        $this->save();

        // Send email
        Mail::send(
            'newsletter::emails.activation',
            ['subscriber' => $this],
            function ($message) {
                $message->to($this->getEmail());
                $message->subject('Hírlevél feliratkozás megerősítése');
            }
        );
    }

    /**
     * Gets the link to the activation of the subscription.
     *
     * @return string
     */
    public function getActivationLink()
    {
        return route(
            'newsletter.activate-subscription',
            ['id' => $this->getAttributeValue($this->getUniqueIdAttributeName())]
        );
    }

    /**
     * Gets the name of the route used to activate a newsletter subscription.
     *
     * @return string
     */
    protected function getActivationRouteName()
    {
        return 'newsletter.activate';
    }

    /**
     * Gets the name of the email attribute.
     *
     * @return string
     */
    protected function getEmailAttributeName()
    {
        return 'email';
    }

    /**
     * Sets the unique id of the user.
     */
    protected function setRandomUniqueId()
    {
        $this->setAttribute('unique_id', $this->getRandomId());
    }

    /**
     * Gets a random unique identifier. Uses a v4 GUID.
     *
     * @return string
     */
    protected function getRandomId()
    {
        return Uuid::generate(4);
    }

    /**
     * Gets the subscriber list relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function subscriberList()
    {
        return $this->belongsTo(SubscriberList::class);
    }

    /**
     * Finds a subscriber identified by its unique id and
     * tries to activate it. Returns the activated subscriber
     * on success, false otherwise.
     *
     * @param string $uniqueId
     * @return Subscriber|false
     */
    public static function findAndActivate($uniqueId)
    {
        $user = User::where(static::getUniqueIdAttributeName(), '=', $uniqueId)
            ->where(static::getIsActiveAttributeName(), '=', false)
            ->first();

        if (is_null($user)) {
            // Not found
            return false;
        }

        // Activate
        $user->is_active = true;
        $user->save();

        return $user;
    }

    /**
     * Gets the name of the unique_id attribute.
     *
     * @return string
     */
    protected static function getUniqueIdAttributeName()
    {
        return 'unique_id';
    }

    /**
     * Gets the name of the is_active attribute.
     *
     * @return string
     */
    protected static function getIsActiveAttributeName()
    {
        return 'is_active';
    }
}
