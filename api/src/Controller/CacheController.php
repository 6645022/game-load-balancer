<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Service\CacheService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CacheController extends Controller
{

    private $_cacheService;

    public function __construct(CacheService $cacheService) {
        $this->_cacheService = $cacheService;
    }
    /**
     * @Route("/clear", name="clear",methods={"DELETE","HEAD"})
     */
    public function clearAction()
    {
        $this->_cacheService->clear();
        return $this->json(true);
    }


}
