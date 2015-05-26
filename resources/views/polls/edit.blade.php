@extends('layout')

@section('content')
    <h1><b>Now Editing</b> {{ $poll->name }}</h1>
    <form action="/polls/{{ $poll->id }}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-row">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $poll->name }}">
        </div>
        <div class="form-row">
            <label for="options">Options</label>
            <ul class="options">
                @forelse($poll->options as $option)
                    <li><input type="text" name="options[]" value="{{ $option }}"><button type="button" class="delete-button">✕</button></li>
                @empty
                    <li><input type="text" name="options[]" value=""><button type="button" class="delete-button">✕</button></li>
                @endforelse
            </ul>
            <small>
                <button type="button" class="add-option">Add option</button> or hit <b>Enter</b>.
            </small>
        </div>
        <div class="form-row -inline">
            <label for="active">Is this Poll active?</label>
            <input type="checkbox" name="active" id="active" value="1" {{ $poll->active ? 'checked' : '' }}>
        </div>
        <div class="form-row">
            <button class="primary" type="submit">Save</button>
            <button class="primary" type="submit" name="notify" value="true">Save and Notify #{{ $poll->slack_channel_name }}</button>
        </div>
    </form>
@endsection

@section('footer')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var $options  = $('.options')
        var $add      = $('.add-option')
        var addOption = function() {
            $options.append('<li><input type="text" name="options[]" value=""><button type="button" class="delete-button">✕</button></li>')
            $options.find('li:last-child input').focus()
        }

        $options.on('click', '.delete-button', function(e){
            $(this).parents('li').fadeOut(function(){
                $(this).remove()
            })
            return false
        })

        $add.on('click', addOption)
        $options.on('keypress', 'li', function(e){
            if (e.keyCode === 13) {
                var input = $(this).find('input').val()

                if (input != '') addOption();

                return false
            }
        })
    </script>
@endsection
