<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;


class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $a=Auth::user();
        if($a->role_id==1)
        {
        return $next($request);
        }
       
        return response()->json([
      'message'=>'you are not Admin'
        ]);
    }
}
