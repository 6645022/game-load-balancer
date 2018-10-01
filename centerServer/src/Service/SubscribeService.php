<?php
namespace App\Service;

use Symfony\Component\Cache\Simple\FilesystemCache;

class SubscribeService
{
    public $_subscribes = [];
    private $_cache;

    public function __construct()
    {
        $this->_cache = new FilesystemCache();

    }
    public function getSubscribes($variableKey)
    {
        $_subscribes = $this->_cache->get($variableKey);
        if(count($_subscribes) > 0){
            $this->_subscribes = $_subscribes;
        }else{
            $this->_subscribes = array();
        }
        return $this->_subscribes;
    }

    public function setSubscribes($ip,$variableKey)
    {
        if (!$this->_cache->has($variableKey)) {
            $_subscribes = array();
        }else{
            $_subscribes = $this->_cache->get($variableKey);
        }
        if(!in_array($ip,$_subscribes)){
            array_push($_subscribes,$ip);
            // save a new item in the cache
            $this->_cache->set($variableKey, $_subscribes);

        }
        $this->_subscribes = $_subscribes;
        return $this->_subscribes;

    }
    // remove the cache key
    public function deleteSubscribe($ip,$variableKey)
    {
        $this->_cache->delete($variableKey,$ip);
        return;
    }


    // CLEAR the cache
    public function clearCache($variableKey)
    {
        $this->_cache->clear($variableKey);
        return;
    }
}