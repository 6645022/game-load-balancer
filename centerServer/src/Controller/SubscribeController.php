<?php

namespace App\Controller;

use App\Service\SubscribeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SubscribeController extends Controller
{
    private $_subscribeService;
    private $_variableKey = 'subscribes';

    public function __construct(SubscribeService $subscribeService) {
        $this->_subscribeService = $subscribeService;
    }
    /**
     * @Route("/subscribe", name="subscribe",methods={"GET","HEAD"})
     */
    public function serverSubscribeAction()
    {
        return $this->json($this->_subscribeService->getSubscribes($this->_variableKey));
    }

    /**
     * @Route("/subscribe", name="set Subscribe",methods={"POST","HEAD"})
     */
    public function setServerSubscribeAction(Request $request)
    {
        $ip = $request->get('ip');

        $result = $this->_subscribeService->setSubscribes($ip,$this->_variableKey);

        return $this->json($result);
    }

    /**
     * @Route("/subscribe", name="setServerSubscribe",methods={"DELETE","HEAD"})
     */
    public function deleteServerSubscribeAction(Request $request)
    {
        $ip = $request->get('ip');

        $this->_subscribeService->deleteSubscribe($ip,$this->_variableKey);

        return $this->json($ip);
    }

    /**
     * @Route("/clear-subscribe", name="clear subscribe",methods={"DELETE","HEAD"})
     */
    public function clearSubscribe()
    {

        $this->_subscribeService->clearCache();

        return $this->json(true);
    }


}
