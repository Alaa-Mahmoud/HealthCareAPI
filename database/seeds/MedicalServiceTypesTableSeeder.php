<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MedicalServiceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medical_service_types')->insert([
            ['name' => 'Dental care'],
            ['name' => 'Laboratory and diagnostic care'],
            ['name' => 'Substance abuse treatment'],
            ['name' => 'Preventative care'],
            ['name' => 'Physical and occupational therapy'],
            ['name' => 'Nutritional support'],
            ['name' => 'Pharmaceutical care'],
            ['name' => 'Transportation'],
            ['name' => 'Prenatal care']
        ]);
    }
}
