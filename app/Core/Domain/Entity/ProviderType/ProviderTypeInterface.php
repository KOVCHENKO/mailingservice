<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 4:11 PM
 */

namespace App\Core\Domain\Models\ProviderType;


interface ProviderTypeInterface
{
    public function send($connectionData);
}