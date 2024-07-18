<?php

namespace Database\Seeders;

use App\Models\Drugs;
use Illuminate\Database\Seeder;

class DrugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drugs = [
            "scientific_name" => ["ESOMEPRAZOLE","LEVOCETRIZINE HCL"],
            "commercial_name" => ["ESO-PROTOCOL 20","LEVONDA 5"],
            "manufacture_id" => [1,2],
            "company_id" => [1,1],
            "quantity_available" => [100,],
            "expiry_date" => ["2025-09-08","2024-10-10"],
            "price" => [200,500]
         ];
         
        for($i=0;$i<sizeof($drugs["EN"]);$i++)
            Drugs::create([
                
            ]);
    }
}
