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
     * @Route("/poll", name="poll",methods={"GET","HEAD"})
     */
    public function getPollAction()
    {
        $this->_subscribeService->subscribeToCenterServer();
        $result = $this->_pollService->getPoll();
        return $this->json($result);
    }

    /**
     * @Route("/vote", name="vote selection", methods={"POST","HEAD"})
     */
    public function voteAction(Request $request)
    {
        $vote = $request->get('color');
        $this->_pollService->setVote($vote);
        return $this->json(true);
    }


    /**
     * @Route("/vote-notification", name="vote notification",methods={"POST","HEAD"})
     */
    public function notificationPollVoteAction(Request $request)
    {
        $poll = $request->get('data');
        $this->_pollService->voteNotification($poll);
        return $this->json(true);
    }

}
