<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProductEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $error=false;
        $valid=false;
        $valid1=false;
        $pr=$request->route('id');
        if(!$request->hasHeader('TOKEN'))
        {
            $error=true;
        }
        $token=$request->header('TOKEN');
        try
        {
         $file=base64_decode($token); //فك التشفير
         $json=json_decode($file,true); //فحص إذا يحتوي بيانات

         $filee=file_get_contents(public_path('users.json'));
         $jsonn=json_decode($filee,true);

         $fileee=file_get_contents(public_path('products.json'));
         $jsonnn=json_decode($fileee,true);
         if(!$json){$error=true;}
         if(!isset($json['email'])){$error=true;}
         for($i=0 ; $i<count($jsonn);$i++)
         {
            if($jsonn[$i]['email']==$json['email'] && $jsonn[$i]['password']==$json['password'])
            {
                $valid=true;
            }
         }

         if($jsonn['email']==$jsonnn[$pr]['email'])
         {$valid1=true;}
        }

         catch(\Exception $exception)
        {
            $error=true;
        }
        if($error)
        {
            return response()->json([
                'message'=>'invalid token'
              ]);
        }
        if(!$valid  && !$valid1)
        {
            return response()->json([
                'message'=>'Incorrect Account'
              ]);
        }
        
        return $next($request);
    }
}
