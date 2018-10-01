<?php

namespace App\Service;

use App\Curl;
use Symfony\Component\Cache\Simple\FilesystemCache;


class PollService extends Curl
{
    private $_centerServer = "http://127.0.0.1:8008";
    private $_cacheColor = "color";
    private $_cache;

    public function __construct()
    {
        $this->_cache = new FilesystemCache();

    }
    public function getPoll()
    {
        $result = $this->_cache->get($this->_cacheColor);
        if($result == null) {
            $this->_cache->delete($this->_cacheColor);

            $result = $this->curlGet($this->_centerServer . '/poll');
            if ($result != null) {
                $this->_cache->set($this->_cacheColor, $result, 3600);
            }
        }

        return json_decode($result, true);
    }

    public function voteNotification($data){
        if($data != null) {
            $this->_cache->set($this->_cacheColor, $data);
        }
        return;
    }

    public function setVote($color)
    {
        $this->curlPost($this->_centerServer.'/vote',[
            'color' => $color
        ]);
        return;
    }


}