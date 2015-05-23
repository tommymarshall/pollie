<?php namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Http\Controllers\Controller;

class PollController extends Controller {

    public function __construct()
    {
        // $this->middleware('admin');
    }

    public function edit($id)
    {
        $poll  = Poll::find($id)->with(['votes.user', 'user'])->first();

        foreach($poll->votes as $vote)
        {
            $options = $poll->$options[$vote->selection];
        }

        return view('polls.edit')->with(compact('poll', 'options'));
    }

    public function update($id)
    {
        if ($poll = Poll::find($id)->update(Request::all()))
        {
            $message = 'Successfully updated';
        }
        else
        {
            $message = 'There was a problem';
        }

        return redirect('polls/'.$id)->with(compact('message'))->withInput();
    }

}
