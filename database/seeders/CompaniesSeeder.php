<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
 
        $names = [
            "EN" => ["Tramedica","Al-Fares","Unipharma"] ,
           "AR" => ["التراماديكا","الفارس","يونيفار ما"]
         ];
         
        for($i=0;$i<sizeof($names["EN"]);$i++)
            Company::create([
                "nameEN" => $names["EN"][$i],
                "nameAR" => $names["AR"][$i]
            ]);
    }
}

