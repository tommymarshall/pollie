<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Poll;
use App\Http\Controllers\Controller;

class PollController extends Controller {

    public function __construct()
    {
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
            $slack = app('Slack');
            $slack->chat('#'.$poll->slack_channel_name)
                  ->send(implode('\n', $poll->options));

            $message = 'Successfully updated and the Options in #'.$poll->slack_channel_name.' room';
        }

        return redirect('polls/'.$id)->with(compact('message'));
    }

}
