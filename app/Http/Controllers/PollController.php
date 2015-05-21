<?php namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Http\Controllers\Controller;

class PollController extends Controller {

    protected $slack;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        $id = Poll::create(Request::all());

        return redirect('polls/'.$poll->id);
    }

    public function edit($id)
    {
        $poll    = Poll::find($id)->with(['votes.user', 'user'])->first();
        $options = $poll->options;

        return view('polls.show')->with(compact('poll', 'options'));
    }

    public function update($id)
    {
        $poll = Poll::find($id)->update(Request::all());

        return view('polls.show')->with(compact('poll'));
    }

}
