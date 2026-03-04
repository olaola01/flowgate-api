<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Guards management endpoints with a static admin token.
 */
class EnsureFlowgateAdmin
{
    /**
     * Validate the admin header token before allowing access.
     */
    public function handle(Request $request, Closure $next)
    {
        $provided = $request->header('X-Admin-Token');
        $expected = config('flowgate.admin_token');

        if (! is_string($provided) || ! is_string($expected) || ! hash_equals($expected, $provided)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
