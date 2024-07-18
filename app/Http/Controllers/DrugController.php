<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\Drugs;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    //add a new drug
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scientific_name' => 'required',
            'commercial_name' => 'required',
            'manufacture_id' => 'required',
            'company_id' => 'required',
            'quantity_available' => 'required',
            'expiry_date' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ], 500);
        }

        $input = $request->all();
        $a = Drugs::where('commercial_name', $input['commercial_name'])->first();
        if ($a) {

            if ($a->quantity_available == 0) {
                $a->expiry_date = $input['expiry_date'];
            }

            $a->quantity_available += $input['quantity_available'];
            $a->save();
            return response()->json([
                'message' => 'the drug is added'
            ]);
        }

        $drug = Drugs::create($input);
        return response()->json([
            'data' => $drug,
            'message' => 'A new drug has been added '
        ]);
    }

    //search for drug
    public function search($name = '')
    {
        $search = Drugs::with('company')->where('commercial_name', 'like', '%' . $name . '%')->get();



        $data = [];
        foreach ($search as $item) {
            if ($item->expiry_date >= now() && $item->quantity_available)
                $data[] = $item;
        }
        if (count($data))
            return response()->json($data);

        return response()->json();
    }

    public function show($id)
    {
        $drug = Drugs::where('id', $id)->with(['company', 'manufacture'])->get();
        return response()->json($drug);
    }
}
