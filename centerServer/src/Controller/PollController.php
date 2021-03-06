<?php

namespace App\Controller;

use App\Service\PollService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PublisherService;


class PollController extends Controller
{

    private $_pollService;
    private $_publisherService;

    public function __construct(PollService $pollService,PublisherService $publisherService) {
        $this->_pollService = $pollService;
        $this->_publisherService = $publisherService;

    }
    /**
     * @Route("/poll", name="poll result  master",methods={"GET","HEAD"})
     */
    public function pollAction()
    {
        $result = $this->_pollService->getPoll();
        return $this->json($result);
    }

    /**
     * @Route("/vote", name="vote  master", methods={"POST","HEAD"})
     */
    public function voteAction(Request $request)
    {
        $votes = $request->get('votes');
        $callerIp = $request->get('ip');
        $this->_pollService->setVote($votes);

        $this->_publisherService->sendNotification('subscribes',json_encode(json_decode($votes),true),$callerIp);

        return $this->json($votes);
    }

}
