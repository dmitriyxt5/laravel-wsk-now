<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $tok = substr($token, 7);

        $user = User::where('token', $tok)->first();
        if (!$user) {
            return response()->json([
                'Message' => 'Unauthorized user',
            ], 401);
        }
        $request->setUserResolver(fn() => $user);
//        return response()->json([$tok]);
        return $next($request);
    }
}
