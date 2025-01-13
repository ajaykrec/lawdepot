<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate_customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {     
       $customer = Auth::guard('customer')->user();   
       //p($customer->status);          
       if(!$customer){
            return redirect( route('customer.login') );
       }
       return $next($request);
    }
}
