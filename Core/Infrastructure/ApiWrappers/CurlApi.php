<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 4/13/18
 * Time: 11:45 AM
 */

namespace Core\Infrastructure\ApiWrappers;


use Core\Domain\ApiWrappers\CurlApiInterface;

class CurlApi implements CurlApiInterface
{
    public function makeGetRequest($url, $data)
    {
        /*
        $res = $this->request('GET', $url, [
            'query' => $data
        ]);

        $result = $res->getBody();
        */
    }
}