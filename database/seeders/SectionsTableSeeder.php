<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecord = [
            ['id' => 1, 'name' => 'Nam','status'=> 1],
            ['id' => 2, 'name' => 'Nữ','status'=> 1],
            ['id' => 3, 'name' => 'New Arrivals','status'=> 1],
        ];

        Section::insert($sectionRecord);
    }
}
