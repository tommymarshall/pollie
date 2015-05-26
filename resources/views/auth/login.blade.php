@extends('layout')

@section('content')
    <h1><b>Attemping to Access</b> {{ $poll->name }}</h1>
    <form action="pin" method="POST" class="pin-form">
        <input type="hidden" name="poll_id" value="{{ $poll->id }}">
        <div class="form-row">
            <input type="text" name="pin" placeholder="PIN">
        </div>
        <div class="form-row">
            <button class="primary" type="submit">Login</button>
        </div>
    </form>
@endsection

