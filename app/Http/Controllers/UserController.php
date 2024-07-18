<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //sign up
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'password' => 'required',
            'C_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ], 401);
        }

        $input = $request->all();
        $input['role_id'] = 2;
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $token = $user->createToken('alosh')->accessToken;
        $success = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json([
            'data' => $success,
            'message' => 'sing up successfully'
        ]);
    }

    //login
    public function login(Request $request)
    {
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
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

    //user information
    public function info()
    {
        $user = User::where('id', Auth::id())->get(['name', 'phone']);
        return response()->json($user);
    }
}
