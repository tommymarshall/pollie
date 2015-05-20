<?php namespace App;

$app->get('/', function() use ($app) {
    return 'hi';
});

$app->post('vote', function() use ($app) {
    $room = Request::input('room');
    $vote = Request::input('vote');
});

$app->get('results/{id}', function($id) use ($app) {
    return Poll::find($id)->with('votes')->get();
});

$app->post('polls/create', function() use ($app) {
    $id = Poll::create(Request::all());

    return redirect('polls/'.$poll->id);
});

$app->get('polls/{id}', function($id) use ($app) {
    $poll    = Poll::find($id)->with(['votes.user', 'user'])->first();
    $options = $poll->options;

    return view('polls.edit')->with(compact('poll', 'options'));
});

$app->put('polls/{id}', function($id) use ($app) {
    if ($poll = Poll::update(Request::all()))
    {
        return view('polls.show')->with(compact('poll'));
    }
    else
    {
        return view('polls.show')->with(compact('poll'));
    }
});
