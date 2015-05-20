<h1>Poll Details for {{ $poll->name }}</h1>
<p>By <b>{{ $poll->user->name }}</b></p>

<h2>Votes</h2>
<ul>
    @foreach($poll->votes as $vote)
        <li>{{ $options[$vote->selection] }} by {{ $vote->user->name }}</li>
    @endforeach
</ul>
