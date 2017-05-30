<?php

namespace App\Http\Middleware;

use Closure;

class ElasticBeanstalkHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->setTrustedProxies(
            ['127.0.0.1', $request->server->get('REMOTE_ADDR')],
            $request::HEADER_X_FORWARDED_AWS_ELB
        );

        return $next($request);
    }
}
