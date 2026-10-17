<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveAccount
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->role === 'member' && $user->account_status === 'pending') {
            return redirect()->route('membership.pending');
        }

        if ($user?->role === 'member' && $user->account_status !== 'active') {
            abort(403, 'This account is not currently permitted to access account settings.');
        }

        return $next($request);
    }
}
