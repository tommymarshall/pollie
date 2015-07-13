<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slacker;
use App\Vote;
use App\Poll;
use App\Http\Controllers\Controller;

class SlackController extends Controller {

    protected $slack;

    protected $incoming;

    protected $slacker;

    protected $events = ['create', 'vote', 'close'];

    public function __construct()
    {
        $this->middleware('slack');

        $this->slacker = new Slacker;
    }

    public function listen(Request $request)
    {
        $payload = $this->formatPayload($request->all());
        $command = $this->getCommand($payload);
        $message = $this->getMessage($payload);

        switch ($command) {
            case 'create':
                $this->createPoll($message);
                break;

            case 'vote':
                $this->submitVote($message);
                break;

            case 'results':
                $this->showResults($message);
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

    private function getCommand($payload)
    {
        $words    = explode(' ', $payload);
        $words[0] = str_replace(':', '', $words[0]);

        foreach ($this->events as $event) {
            if (in_array($event, $words))
            {
                return $event;
            }
        }
    }

    private function getMessage($payload)
    {
        return stristr($payload, ' ');
    }

    private function formatPayload($payload)
    {
        return array_shift(explode(' ', $payload));
    }

}
