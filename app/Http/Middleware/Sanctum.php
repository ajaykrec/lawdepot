<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Sanctum
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bearer = $request->bearerToken();
        if (!$bearer) {
            return response()->json([
                'success' => false,
                'error' => 'Autorization required!',
            ],202);
        }
        [$id, $token] = explode('|', $bearer, 2);    
        $token = hash('sha256',$token);  
        if($token = DB::table('personal_access_tokens')->where('token', $token)->first() ){
            if($user = \App\Models\Customers::find($token->tokenable_id)){  
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'error' => 'Access denied.',
        ],202);
    }
}
