<?php

namespace App\Service;

use App\Curl;
use Symfony\Component\Cache\Simple\FilesystemCache;


class SubscribeService extends Curl
{
    private $_cache;
    private $_centerServer = "http://127.0.0.1:8008";
    private $_variableKey = "serverIp";

    public function __construct()
    {
        $this->_cache = new FilesystemCache();
    }
    public function subscribeToCenterServer()
    {
        $serverIp = $_SERVER['HTTP_HOST'];

        if (!$this->_cache->has($this->_variableKey)) {
            $_subscribes = array();
        }else{
            $_subscribes = $this->_cache->get($this->_variableKey);
        }
        if(!in_array(str_replace('\/','/',$serverIp),$_subscribes)){

            $this->curlPost($this->_centerServer.'/subscribe',[
                'ip'=>$serverIp.'/'.'vote-notification'
            ]);

            array_push($_subscribes,$serverIp);
            // save a new item in the cache
            $this->_cache->set($this->_variableKey, $_subscribes,3600);
        }
        return;
    }
}