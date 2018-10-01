<?php

namespace App\Service;

use App\Curl;
use App\Service\CacheService;


class SubscribeService extends Curl
{
    private $_cacheService;
    private $_centerServer = "http://127.0.0.1:8008";
    private $_variableKey = "serverIp";

    public function __construct(CacheService $cacheService)
    {
        $this->_cacheService = $cacheService;
    }
    public function subscribeToCenterServer()
    {
        $serverIp = $_SERVER['HTTP_HOST'];

        if (!$this->_cacheService->has($this->_variableKey)) {
            $_subscribes = array();
        }else{
            $_subscribes = $this->_cacheService->get($this->_variableKey);
        }
        if(!in_array(str_replace('\/','/',$serverIp),$_subscribes)){

            $this->curlPost($this->_centerServer.'/subscribe',[
                'ip'=>str_replace('\/','/',$serverIp.'/'.'vote-notification')
            ]);

            array_push($_subscribes,$serverIp);
            // save a new item in the cache
            $this->_cacheService->set($this->_variableKey, $_subscribes,3600);
        }
        return;
    }
}