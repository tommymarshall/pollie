<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poll;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

    public function form(Request $request)
    {
        $poll = Poll::find($request->session()->get('attempt'));

        return view('auth.login')->with(compact('poll'));
    }

    public function login(Request $request)
    {
        $poll = Poll::find($request->session()->get('attempt'));

        if ($request->input('pin') == $poll->pin)
        {
            $request->session()->forget('attempt');
            $request->session()->put('admin.'.$poll->id, true);

            return redirect('polls/'.$poll->id);
        }

        return redirect('pin')->with(['message' => 'Wrong pin']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return view('auth.logout');
    }

}
