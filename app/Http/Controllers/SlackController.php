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

        $this->slack = app('Slack');
    }

    public function listen(\Request $request)
    {
        // $this->incoming = $slack->listen($request->all());
        $this->incoming = $this->slack->listen([
            'token'        => '1wjXO8lq4Mb4wAV9QrRDCwQZ',
            'team_id'      => 'T0001',
            'channel_id'   => 'C2147483705',
            'channel_name' => 'test',
            'timestamp'    => '1355517523.000005',
            'user_id'      => 'U2147483697',
            'user_name'    => 'Steve',
            'text'         => 'pollie: create when will tommy get a new job'
        ]);

        $command = $this->getCommand($this->incoming->words());

        $payload = substr($this->incoming->text(), 7);

        switch ($command) {
            case 'create':
                $this->createPoll($payload);
                break;

            case 'vote':
                $this->submitVote($payload);
                break;

            case 'results':
                $this->showResults(trim($payload));
                break;

            default:
                return $this->incoming->respond("NO IDEA WHAT YOU'RE TALKING ABOUT");
                break;
        }
    }

    public function createPoll($name)
    {
        if ($poll = Poll::activeChannel($this->incoming->channelId())->first())
        {
            return $this->incoming->respond("There's already an active vote! {$poll->name}");
        }

        $password = rand(1000, 9999);

        $poll = Poll::create([
            'name'     => $name,
            'password' => $password,
        ]);

        $message = 'Edit your poll at '.url('polls/'.$poll->id.'/edit').'. Password is *'.$password.'*';

        return $this->incoming->respond($message, '@'.$this->incoming->user());
    }

    public function showResults($channel = null)
    {
        $results = Poll::resultsFor($channel ?: $this->incoming->channelId())->first();

        $message = "Poll Results: ".$results;

        return $this->incoming->respond($message);
    }

    public function submitVote($vote)
    {
        if ($poll = Poll::active($this->incoming->channelId()))
        {
            $poll->votes()->create([
                'user_id'   => User::getSlackId($this->incoming->userId()),
                'selection' => $vote,
            ]);
        }

        return $this->incoming->respond($message, '@'.$this->incoming->user());
    }

    private function getCommand($words)
    {
        foreach ($this->events as $event) {
            if (in_array($event, $words))
            {
                return $event;
            }
        }
    }

}
