<?php

namespace App\Models\ChannelType;

class EmailChannel implements ChannelInterface
{
    public $type = 'email';

    public function send()
    {
        dd("Catch Email");
        // TODO: Implement send() method.
    }

    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }
}
