<?php

namespace Database\Seeders;

use App\Models\Cases;
use App\Models\Status;
use Illuminate\Database\Seeder;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            "EN" => ["pending","sent","received"] ,
           "AR" => ["قيد التحضير","تم الارسال"," تم الاستلام"]
         ];
         
        for($i=0;$i<sizeof($names["EN"]);$i++)
            Status::create([
                "nameEN" => $names["EN"][$i],
                "nameAR" => $names["AR"][$i]
            ]);

        
    }
}
