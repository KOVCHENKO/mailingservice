<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 4:11 PM
 */

namespace App\Models\ChannelType;


interface ChannelInterface
{
    public function send($connectionData);

    public function getStatus($messageId);
}