<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{

    public function index()
    {
        $user = User::find(auth()->id());
        return $user->load('drugs');
    }


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drug_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ]);
        }

        $user = User::find(auth()->id());
        $user->drugs()->syncWithoutDetaching($request->drug_id);

        return response()->json(['message' => "Adding to favorite successfully"]);
    }


    public function delete(Request $request)
    {
        $user = User::find(auth()->id());
        $user->drugs()->detach($request->drug_id);
        return response()->json(['message' => "Deleting from favorite successfully"]);
    }
}
