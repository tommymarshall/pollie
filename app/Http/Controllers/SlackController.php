<?php namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Http\Controllers\Controller;

class SlackController extends Controller {

    protected $slack;

    protected $incoming;

    protected $events = ['create', 'vote', 'close'];

    public function __construct()
    {
        $this->middleware('slack');
        $this->slack = $app->make('Slack');
    }

    public function listen(Request $request)
    {
        // $this->incoming = $slack->listen($request->all());
        $this->incoming = $slack->listen([
            'token'        => '1wjXO8lq4Mb4wAV9QrRDCwQZ',
            'team_id'      => 'T0001',
            'channel_id'   => 'C2147483705',
            'channel_name' => 'test',
            'timestamp'    => '1355517523.000005',
            'user_id'      => 'U2147483697',
            'user_name'    => 'Steve',
            'text'         => 'pollie: create when will tommy get a new job'
        ]);

        $command = $this->getCommand($incoming->word());

        $message = substr($command, 7);

        switch ($command) {
            case 'create':
                $this->createPoll($message);
                break;

            case 'vote':
                $this->submitVote($message);
                break;

            case 'results':
                $this->showResults();
                break;

            default:
                return $this->incoming->response("NO IDEA WHAT YOU'RE TALKING ABOUT");
                break;
        }
    }

    public function createPoll($name)
    {
        if ($poll = Poll::active($this->incoming->channelId()))
        {
            return $this->incoming->response("There's already an active vote! {$poll->name}");
        }

        $password = str_random(4);

        $poll = Poll::create([
            'name'     => $name,
            'password' => $password,
        ]);

        $message = 'Edit your poll at '.url('polls/'.$created_poll->id).'. Password is *'.$password.'*';

        return $this->incoming->respond($message, '@'.$this->incoming->user());
    }

    public function showResults($channel = null)
    {
        $results = Poll::resultsFor($channel ?: $this->incoming->channelId());

        $message = "Poll Results: ".$results;

        return $this->incoming->respond($message);
    }

    public function submitVote($vote)
    {
        if ($poll = Poll::active($this->incoming->channelId()))
        {
            $created_poll = $poll->votes()->create([
                'user_id'   => User::getSlackId($this->incoming->userId()),
                'selection' => (int) $vote,
            ]);
        }

        return $this->incoming->respond($message, '@'.$this->incoming->user());
    }

    private function getCommand($words)
    {
        foreach ($events as $event) {
            if (in_array($event, $words))
            {
                return $event;
            }
        }
    }

}
