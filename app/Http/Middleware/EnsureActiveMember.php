<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== 'member') {
            abort(403);
        }

        if ($user->account_status === 'pending') {
            return redirect()->route('membership.pending');
        }

        if ($user->account_status !== 'active') {
            abort(403, 'This account is not currently permitted to access the member portal.');
        }

        return $next($request);
    }
}
