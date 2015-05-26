@extends('layout')

@section('content')
    <h1><b>Hi, I'm</b> Pollie</h1>
    <p>Nothing lives here. All the things are accessible via slack.</p>

    <h3>Create Poll</h3>
    <code>/pollie create What will we move into the new HQ?</code>
    <h3>Outputs options</h3>
    <code>/pollie show</code>
    <h3>Votes for option 2</h3>
    <code>/pollie vote 2</code>
    <h3>Updates previous vote to option 3</h3>
    <code>/pollie vote 3</code>

@endsection

