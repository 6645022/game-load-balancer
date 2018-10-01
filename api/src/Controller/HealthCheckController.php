<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HealthCheckController extends Controller
{

    /**
     * @Route("/ping", name="healthCheck",methods={"GET","HEAD"})
     */
    public function healthCheckAction()
    {
        return $this->json(true);
    }


}
