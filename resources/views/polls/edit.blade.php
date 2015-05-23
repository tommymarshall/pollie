@extends('layouts.default')

@section('content')
    <h1>Editing Poll Details for {{ $poll->name }}</h1>
    <form action="/polls/{{ $poll->id }}/edit" method="post">
        <div class="form-row">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $poll->name }}">
        </div>
        <div class="form-row">
            <label for="options">Options</label>
            <small>Options on new lines</small>
            <textarea name="options"></textarea>
        </div>
    </form>
@endsection

