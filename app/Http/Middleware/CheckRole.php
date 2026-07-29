<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\MemberRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            Log::warning('CheckRole: unauthenticated access attempt', [
                'path' => $request->path(),
                'ip' => $request->ip(),
                'roles_required' => $roles,
            ]);
            abort(401);
        }

        foreach ($roles as $role) {
            if ($user->role === MemberRole::tryFrom($role)) {
                return $next($request);
            }
        }

        Log::warning('CheckRole: unauthorized access attempt', [
            'user_id' => $user->id,
            'user_role' => $user->role->value,
            'path' => $request->path(),
            'ip' => $request->ip(),
            'roles_required' => $roles,
        ]);
        abort(403);
    }
}
