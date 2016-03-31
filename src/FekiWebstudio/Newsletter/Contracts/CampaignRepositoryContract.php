<?php
/**
 * Created by Feki Webstudio - 2016. 03. 31. 9:31
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter\Contracts;

/**
 * Interface CampaignRepositoryContract defines an interface
 * for campaign repositories.
 *
 * @package FekiWebstudio\Newsletter\Contracts
 */
interface CampaignRepositoryContract
{
    /**
     * Gets a campaign identified by the provided identifier.
     *
     * @param mixed $identifier
     * @return CampaignContract|null
     */
    public function getCampaign($identifier);

    /**
     * Gets all subscriber lists with optional limits.
     *
     * @param int $offset
     * @param int $limit
     * @return CampaignContract[]
     */
    public function getCampaigns($offset = 0, $limit = 0);

    /**
     * Creates a new campaign.
     *
     * @param string $subject
     * @return CampaignContract
     */
    public function createCampaign($subject);

    /**
     * Updates a campaign.
     *
     * @param CampaignContract $campaign
     * @return bool
     */
    public function updateCampaign(CampaignContract $campaign);

    /**
     * Deletes a campaign.
     *
     * @param CampaignContract $campaign
     * @return bool
     */
    public function deleteCampaign(CampaignContract $campaign);
}