<?php namespace App\Http\Middleware;

use Closure;

class SlackTokenMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->get('token') == getenv('SLACK_PUBLIC_REQUEST') || $request->get('token') == getenv('SLACK_PRIVATE_REQUEST'))
        {
            return $next($request);
        }

        throw new \Exception("Cannot process request; token mismatch");
    }

}
