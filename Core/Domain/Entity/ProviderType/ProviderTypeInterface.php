<?php

namespace Core\Domain\Models\ProviderType;


interface ProviderTypeInterface
{
    public function send($connectionData);
}