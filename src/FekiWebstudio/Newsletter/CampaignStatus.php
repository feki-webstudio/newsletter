<?php
/**
 * Created by Feki Webstudio - 2016. 04. 05. 13:57
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter;

abstract class CampaignStatus
{
    const CREATED = 0;
    const IN_PROGRESS = 1;
    const SENT = 2;
}