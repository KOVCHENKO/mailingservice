<?php

namespace App\Core\Domain\Entity\ChannelType;


interface ChannelInterface
{
    public function send($connectionData);

    public function getRemoteStatus($messageId);
}