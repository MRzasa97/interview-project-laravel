<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveTrailingSlash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();
        if(substr($uri, -1) === '/' && $uri !== '/')
        {
            $uri = rtrim($uri, '/');
            $request->server->set('REQUEST_URI', $uri);
        }
        return $next($request);
    }
}
