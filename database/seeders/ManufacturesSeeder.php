<?php

namespace Database\Seeders;

use App\Models\Manufacture;
use Illuminate\Database\Seeder;

class ManufacturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
                   "EN" => ["Digestive","Allergy","Diabetes","Pressure","Nervous and Psychological","Heart","Painkiller"] ,
                  "AR" => ["هضمية","حساسية"," سكري"," ضغط","عصبية و نفسية","قلبية ","مسكن الم"]
                ];
                
        for($i=0;$i<sizeof($names["EN"]);$i++)
            Manufacture::create([
                "nameEN" => $names["EN"][$i],
                "nameAR" => $names["AR"][$i]
            ]);
        
    }
}
