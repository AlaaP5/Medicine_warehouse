<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{

    //login
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::query()->find(auth()->user()['id']);
            $success['token'] = $user->createToken('alosh')->accessToken;
            $success['name'] = $user->name;

            return response()->json([
                'data' => $success,
                'message' => 'login successfully'
            ]);
        }

        return response()->json([
            'message' => 'Invalid login'
        ]);
    }


    public function sentNot(Request $request)
    {
        $user_token = User::find($request->id)->fcm_token;
        $sever_key = env('FCM_SERVER_KEY');
        $fcm = Http::acceptJson()->withToken($sever_key)->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $user_token,
                'notification' =>
                [
                    'title' => 'message',
                    'body' => 'your order edit'
                ]
            ]
        );

        return $fcm;
    }
}
