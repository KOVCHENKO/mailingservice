<?php

namespace Core\Domain\ApiWrappers;


interface CurlApiInterface
{
    public function makeGetRequest($url, $data);
}