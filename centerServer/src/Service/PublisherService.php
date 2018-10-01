<?php
namespace App\Service;
use App\Curl;
use App\Service\SubscribeService;

class PublisherService extends Curl
{
    private $_subscribeService;

    public function __construct(SubscribeService $subscribeService)
    {
        $this->_subscribeService = $subscribeService;
    }

    public function sendNotification($variableKey,$data,$callerIp)
    {
        $subscribes = $this->_subscribeService->getSubscribes($variableKey);


        foreach ($subscribes as $subscribe) {
            if(strpos($subscribe, $callerIp) === false){
                if($this->healthCheck($callerIp)){
                    $this->curlPost($subscribe, ['data' => $data]);
                }else{
                    $this->_subscribeService->deleteSubscribe($subscribe,$variableKey);
                }
            }
        }
        return true;
    }

}