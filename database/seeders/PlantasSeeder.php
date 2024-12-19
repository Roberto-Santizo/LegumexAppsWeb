<?php

namespace Database\Seeders;

use App\Models\Planta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plantas = [
            ['name' => 'Congelado Tejar', 'documetold_folder_id' => '01O5NWAPCFNWFZJEKRBNEYTW7WVMMPQP7B' , 'checklist_folder_id' => '01O5NWAPCAQYMXEPUMHFCKVTNWL3BYI3HU', 'ot_folder_id' => '01O5NWAPGZTIYPYFTVVJCZ4FE5O6XEUOC4', 'prefix' => 'CT'],
            ['name' => 'FRESCO', 'documetold_folder_id' => '01O5NWAPCSIAPNTIG7JNE2TLT4PYN3SUQK' , 'checklist_folder_id' => '01O5NWAPHJRNWZ5K3NY5FLELDEVBOP55K4', 'ot_folder_id' => '01O5NWAPDN5G7FN4UN3VHYZSVROXAYL26Q', 'prefix' => 'F'],
            ['name' => 'Planta El Tejar', 'documetold_folder_id' => '01O5NWAPAFPET5P2RUURCLY4EVB2S7EVHC' , 'checklist_folder_id' => '', 'ot_folder_id' => '01O5NWAPCMWLUPTIOUWVHINMYA7TPQYS7D', 'prefix' => 'PT'],
            ['name' => 'Planta Parramos', 'documetold_folder_id' => '01O5NWAPFOX43Q3QU6PJAYF2OOZOP7I5JY' , 'checklist_folder_id' => '', 'ot_folder_id' => '01O5NWAPA546C3CGESE5DJFBKEKQ5IRBT7', 'prefix' => 'PP'],
            ['name' => 'Planta AB', 'documetold_folder_id' => '01O5NWAPFW76RUPLEO5VALL4CYO5YF4TAB' , 'checklist_folder_id' => '01O5NWAPD36MMKDMG2TZBY6M36A3GWO4ET', 'ot_folder_id' => '01O5NWAPASYXLSDODS5FFL5IRYHEMAKIQG', 'prefix' => 'AB'],
        ];

        Planta::insert($plantas); 
    }
}
