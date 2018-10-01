<?php

namespace App\Service;

use App\Curl;

class PollService extends Curl
{
    private $_proxyUrl = "http://127.0.0.1:8009";

    public function getResult()
    {
        $result = $this->curlGet($this->_proxyUrl.'/?route=poll');
        return json_decode($result, true);
    }

    public function vote($color)
    {
        $result = $this->curlPost($this->_proxyUrl,[
        'color' => $color,
        'route'=>'vote'
        ]);
        return json_decode($result, true);
    }
}