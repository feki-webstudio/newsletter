<?php
/**
 * Created by Feki Webstudio - 2016. 04. 05. 13:08
 * @author Zsolt
 * @copyright Copyright (c) 2016, Feki Webstudio Kft.
 */

namespace FekiWebstudio\Newsletter;

use Illuminate\Mail\Message;

class MessagePreview extends Message
{
    /**
     * MessagePreview constructor.
     */
    public function __construct()
    {
        parent::__construct(new \Swift_Message());
    }

    /**
     * Simply returns the link to the asset instead of
     * embedding it.
     *
     * @param string $file
     * @return mixed
     */
    public function embed($file)
    {
        // Remove the public path
        $publicPath = public_path('/');
        $file = str_replace($publicPath, '', $file);

        return asset($file);
    }
}