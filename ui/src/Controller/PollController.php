<?php

namespace App\Controller;

use App\Service\PollService;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PollController extends Controller
{
    private $pollService;


    public function __construct(PollService $pollService) {
        $this->pollService = $pollService;
    }

    /**
     * @Route("/", name="poll",methods={"GET","HEAD"})
     */
    public function index()
    {
        $result = $this->pollService->getResult();
        return $this->render('poll/index.html.twig', [
            'title' => 'Poll Color',
            'colors'=>array_keys($result),
            'result'=> $this->calculatePercentageResult($result)
        ]);
    }

    /**
     * @Route("/poll", name="select poll", methods={"POST","HEAD"})
     */
    public function postAction(Request $request)
    {
        $color = $request->get('poll_option');
        $this->pollService->vote($color);
        return $this->redirect('/');
    }

    private function calculatePercentageResult($result){
        if(count($result)){
            $voterCount = array_sum($result);
            foreach ($result as $key=>$value){
                $result[$key] = ($value > 0)? round(($value * 100.0 / $voterCount),2) : 0;
            }
        }
        arsort($result);
        return $result;
    }
}
