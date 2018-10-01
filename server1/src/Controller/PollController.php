<?php

namespace App\Controller;

use App\Service\PollService;
use App\Service\SubscribeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PollController extends Controller
{
    private $_pollService;
    private $_subscribeService;


    public function __construct(PollService $pollService,SubscribeService $subscribeService) {
        $this->_pollService = $pollService;
        $this->_subscribeService = $subscribeService;
    }

    /**
     * @Route("/poll", name="poll server",methods={"GET","HEAD"})
     */
    public function getPollAction()
    {
        $this->_subscribeService->subscribeToCenterServer();
        $result = $this->_pollService->getPoll();
        return $this->json($result);
    }

    /**
     * @Route("/vote", name="vote selection server", methods={"POST","HEAD"})
     */
    public function voteAction(Request $request)
    {
        $color = $request->get('color');

        $poll = $this->_pollService->getPoll();
        $poll[$color]++;

        $this->_pollService->setVoteCache($poll);
        $this->_pollService->setVote($poll);

        return $this->json($poll);
    }


    /**
     * @Route("/vote-notification", name="vote notification server",methods={"POST","HEAD"})
     */
    public function notificationPollVoteAction(Request $request)
    {
        $poll = $request->get('data');

        $this->_pollService->setVoteCache(json_decode($poll),1);
        return $this->json(true);
    }

}
