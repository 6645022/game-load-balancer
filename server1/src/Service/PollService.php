<?php

namespace App\Service;

use App\Curl;
use APP\Service\CacheService;


class PollService extends Curl
{
    private $_centerServer = "http://127.0.0.1:8008";
    private $_cacheColor = "color";
    private $_cacheService;


    public function __construct(CacheService $cacheService)
    {
        $this->_cacheService = $cacheService;
    }

    public function getPoll()
    {
        $result = $this->_cacheService->get($this->_cacheColor);

        if(!$result || $result == null) {
            $this->_cacheService->delete($this->_cacheColor);

            $result = $this->curlGet($this->_centerServer . '/poll');
            if ($result != null) {
                $this->setVoteCache($result);
            }
        }

        return json_decode($result, true);
    }

    public function setVoteCache($data){
        if($data != null) {
            $this->_cacheService->set($this->_cacheColor, $data,3600);
        }
        return;
    }

    public function setVote($color)
    {
       $result =  $this->curlPost($this->_centerServer.'/vote',[
            'color' => $color,
            'ip' => $_SERVER['HTTP_HOST']
        ]);
        return $result;
    }


}