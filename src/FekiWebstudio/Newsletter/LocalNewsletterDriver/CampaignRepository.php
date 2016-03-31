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
     * Gets a campaign identified by the provided identifier.
     *
     * @param mixed $identifier
     * @return CampaignContract|null
     */
    public function getCampaign($identifier)
    {
        return Campaign::find($identifier);
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
        $campaigns = Campaign::skip($offset);

        if ($limit > 0) {
            $campaigns = $campaigns->take($limit);
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
        return Campaign::create([
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
        if (! $campaign instanceof Campaign) {
            throw new \InvalidArgumentException("The campaign repository of the local newsletter driver only allows instances of the Campaign class");
        }
    }
}