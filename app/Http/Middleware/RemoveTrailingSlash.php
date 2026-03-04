<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveTrailingSlash
{
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();

        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $cleanUri = rtrim($uri, '/');

            return redirect($cleanUri, 301);
        }

        return $next($request);
    }
}
