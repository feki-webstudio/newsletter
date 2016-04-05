<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 9:43
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\LocalNewsletterDriver;

use FekiWebstudio\Newsletter\Contracts\CampaignContract;
use FekiWebstudio\Newsletter\Contracts\CampaignRepositoryContract;

class CampaignRepository implements CampaignRepositoryContract
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
     * Type of the campaign object.
     *
     * @var string
     */
    protected $campaignType;

    /**
     * CampaignRepositoryContract constructor.
     */
    public function __construct()
    {
        $this->subscriberType = config('newsletter.local-driver.subscriber-type');
        $this->campaignType = config('newsletter.local-driver.campaign-type');
        $this->subscriberListType = config('newsletter.local-driver.subscriber-list-type');
    }

    /**
     * Gets a campaign identified by the provided identifier.
     *
     * @param mixed $identifier
     * @return CampaignContract|null
     */
    public function getCampaign($identifier)
    {
        return $this->callStaticMethod($this->campaignType, 'find', $identifier);
    }
    
    /**
     * Gets all subscriber lists with optional limits.
     *
     * @param int $offset
     * @param int $limit
     * @return CampaignContract[]
     */
    public function getCampaigns($offset = 0, $limit = 0)
    {
        $campaigns = $this->callStaticMethod($this->campaignType, 'orderBy', ['created_at', 'desc'], true);

        if ($limit > 0) {
            $campaigns = $campaigns->offset($offset)->take($limit);
        }

        return $campaigns->get();
    }
    
    /**
     * Creates a new campaign.
     *
     * @param string $subject
     * @return CampaignContract
     */
    public function createCampaign($subject)
    {
        return $this->callStaticMethod($this->campaignType, 'create', [
            'subject' => $subject
        ]);
    }

    /**
     * Updates a campaign.
     *
     * @param CampaignContract $campaign
     * @return bool
     */
    public function updateCampaign(CampaignContract $campaign)
    {
        $this->checkCampaignType($campaign);

        return $campaign->save();
    }

    /**
     * Deletes a campaign.
     *
     * @param CampaignContract $campaign
     * @return bool
     */
    public function deleteCampaign(CampaignContract $campaign)
    {
        $this->checkCampaignType($campaign);

        $campaign->delete();
    }
    
    /**
     * Checks whether the provided campaign object has a proper type.
     *
     * @param mixed $campaign
     * @throws \InvalidArgumentException
     */
    protected function checkCampaignType($campaign)
    {
        $campaignType = $this->campaignType;

        if (! $campaign instanceof $campaignType) {
            throw new \InvalidArgumentException("The campaign repository of the local newsletter driver only allows 
                instances of the Campaign class");
        }
    }

    /**
     * Constructs a new campaign object without saving it.
     *
     * @return CampaignContract
     */
    public function constructCampaignObject()
    {
        $campaignType = $this->campaignType;

        return new $campaignType();
    }

    /**
     * Gets the number of all campaigns.
     *
     * @return int
     */
    public function getCampaignsCount()
    {
        return $this->callStaticMethod($this->campaignType, 'count', 'id');
    }

    /**
     * Calls a static method of an object with the given type.
     *
     * @param string $type
     * @param string $method
     * @param mixed $params
     * @param bool $multiParam
     * @return mixed
     */
    protected function callStaticMethod($type, $method, $params = null, $multiParam = false)
    {
        if ($multiParam) {
            return call_user_func_array($type . "::" . $method, $params);
        } else {
            return call_user_func($type . "::" . $method, $params);
        }
    }
}