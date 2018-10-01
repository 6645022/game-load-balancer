<?php
namespace App\Service;

use APP\Service\CacheService;

use Symfony\Component\Cache\Simple\FilesystemCache;

class SubscribeService
{
    public $_subscribes = [];
    private $_cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->_cacheService = $cacheService;
    }
    public function getSubscribes($variableKey)
    {
        $_subscribes = $this->_cacheService->get($variableKey);
        if(count($_subscribes) > 0){
            $this->_subscribes = $_subscribes;
        }else{
            $this->_subscribes = array();
        }
        return $this->_subscribes;
    }

    public function setSubscribes($ip,$variableKey)
    {
        if (!$this->_cacheService->has($variableKey)) {
            $_subscribes = array();
        }else{
            $_subscribes = $this->_cacheService->get($variableKey);
        }
        if(!in_array($ip,$_subscribes)){
            array_push($_subscribes,$ip);
            // save a new item in the cache
            $this->_cacheService->set($variableKey, $_subscribes);

        }
        $this->_subscribes = $_subscribes;
        return $this->_subscribes;

    }
    // remove server subscribe from list
    public function deleteSubscribe($subscribe,$variableKey)
    {
        $_subscribes = $this->_cacheService->get($variableKey);

        if(!in_array($subscribe,$_subscribes)){
            $key = array_search ($subscribe, $_subscribes);
            unset($_subscribes[$key]);

            $this->_cacheService->set($variableKey, $_subscribes);
        }
        return;
    }

    // CLEAR the cache
    public function clearCache()
    {
        $this->_cacheService->clear();
        return;
    }
}