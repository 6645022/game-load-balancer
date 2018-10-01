<?php

namespace App\Service;

use Symfony\Component\Cache\Simple\FilesystemCache;


class CacheService
{
    private $_cache;
    private $_ttl = 6600;

    public function __construct()
    {
        $this->_cache = new FilesystemCache();
    }

    public function clear(){
        $this->_cache->clear();
    }
    public function get($variableKey){
        return $this->_cache->get($variableKey);
    }
    public function set($variableKey,$data){
        $this->_cache->set($variableKey,$data,$this->_ttl);

    }
    public function has($variableKey){
        $this->_cache->has($variableKey);

    }
    public function delete($variableKey){
        $this->_cache->delete($variableKey);
    }

}