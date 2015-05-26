<?php namespace App\Http\Middleware;

use Closure;
use App\Poll;

class AdminMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = explode('/', $request->url());

        $post_id = end($url);

        if ($request->session()->has('admin.'.$post_id))
        {
            return $next($request);
        }

        $request->session()->put('attempt', $post_id);

        $poll = Poll::findOrFail($post_id);

        return redirect('pin')->with(compact('poll'));
    }

}
