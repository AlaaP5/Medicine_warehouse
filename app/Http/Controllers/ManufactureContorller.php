<?php

namespace App\Http\Controllers;

use App\Models\Drugs;
use App\Models\Manufacture;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ManufactureContorller extends Controller
{
    //get all cantegory
    public function all()
    {
        $category = Manufacture::all();
        return response()->json($category);
    }

    //get all drugs with same category
    public function showDrugsByCategory($id)
    {
        $q = Drugs::where('manufacture_id', $id)->with('company')->get();
        return response()->json($q);
    }

    //search for category
    public function search($name = "")
    {
        $category = Manufacture::where('nameEN', 'like', '%' . $name . '%')
            ->orWhere('nameAR', 'like', '%' . $name . '%')->get();

        if (count($category))
            return response()->json($category);

        return response()->json(['message' => "$name is not found"]);
    }
}
