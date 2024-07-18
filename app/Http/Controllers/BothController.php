<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Manufacture;
use Illuminate\Http\Request;

class BothController extends Controller
{
    public function logout()
    {
        /**@var \App\Models\MyUserModel */
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'logged out Successfully'
        ]);
    }
}
