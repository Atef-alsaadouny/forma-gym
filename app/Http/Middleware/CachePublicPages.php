<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CachePublicPages
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->isSuccessful() && $request->isMethod('GET')) {
            $response->headers->set('Cache-Control', 'public, max-age=3600, must-revalidate');
            $response->headers->set('Vary', 'Cookie, Accept-Language');
        }

        return $response;
    }
}
