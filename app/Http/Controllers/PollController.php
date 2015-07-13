<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Poll;
use App\Slacker;
use App\Http\Controllers\Controller;

class PollController extends Controller {

    protected $slacker;

    public function __construct()
    {
        $this->slacker = new Slacker;
        $this->middleware('admin');
    }

    public function edit($id)
    {
        $poll = Poll::find($id);

        return view('polls.edit')->with(compact('poll'));
    }

    public function update(Request $request, $id)
    {
        $poll = Poll::find($id);
        $poll->name    = $request->input('name');
        $poll->options = array_filter($request->input('options', []));
        $poll->active  = $request->input('active');
        $poll->save();

        if ($request->input('notify'))
        {
            $this->slacker->to('#'.$poll->slack_channel_name)
                          ->text($poll->options)
                          ->send();

            $message = 'Successfully updated poll in #'.$poll->slack_channel_name.' room';
        }

        return redirect('polls/'.$id)->with(compact('message'));
    }

}
