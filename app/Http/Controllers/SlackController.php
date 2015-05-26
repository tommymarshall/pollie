<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;
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

    public function listen(Request $request)
    {
        $this->incoming = $this->slack->listen($request->all());
        // $this->incoming = $this->slack->listen([
        //     'token'        => '1wjXO8lq4Mb4wAV9QrRDCwQZ',
        //     'team_id'      => 'T0001',
        //     'channel_id'   => 'C2147483705',
        //     'channel_name' => 'test',
        //     'timestamp'    => '1355517523.000005',
        //     'user_id'      => 'U2147483697',
        //     'user_name'    => 'Steve',
        //     'text'         => 'pollie: vote 2'
        // ]);

        $command = $this->getCommand($this->incoming->words());

        $payload = $this->incoming->text();

        switch ($command) {
            case 'create':
                $this->createPoll(substr($payload, 7));
                break;

            case 'vote':
                $this->submitVote(substr($payload, 5));
                break;

            case 'results':
                $this->showResults(substr($payload, 8));
                break;

            default:
                $this->incoming->respond("NO IDEA WHAT YOU'RE TALKING ABOUT");
                break;
        }
    }

    public function createPoll($name)
    {
        if ($poll = Poll::activeChannel($this->incoming->channelId())->first())
        {
            $this->incoming->respond("There's already an active vote! {$poll->name}");
        }

        $pin = rand(1000, 9999);

        $poll = Poll::create([
            'name'               => $name,
            'pin'                => $pin,
            'slack_user_id'      => $this->incoming->userId(),
            'slack_channel_id'   => $this->incoming->channelId(),
            'slack_channel_name' => $this->incoming->channel(),
            'options'            => ['option one', 'option two']
        ]);

        $message = 'Edit your poll at '.url('polls/'.$poll->id).'. Password pin is *'.$pin.'*';

        $this->incoming->respond($message, '@'.$this->incoming->user());
    }

    public function showResults($channel = null)
    {
        $results = Poll::resultsFor($channel ?: $this->incoming->channelId())->first();

        dd($results);

        $message = "Poll Results: ";

        $this->incoming->respond($message);
    }

    public function submitVote($selection)
    {
        $poll = Poll::activeChannel($this->incoming->channelId())->first();

        if ($poll)
        {
            $vote = Vote::firstOrNew([
                'slack_user_id' => $this->incoming->userId(),
                'poll_id'       => $poll->id,
            ]);
            $vote->selection = $selection;
            $vote->save();

            $poll->votes()->save($vote);

            $message = 'Voted for *'.$poll->options[$selection - 1].'*';
        }
        else
        {
            $message = "There is no poll in this channel.";
        }

        $this->incoming->respond($message, '@'.$this->incoming->user());
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
