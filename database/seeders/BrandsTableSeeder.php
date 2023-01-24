<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
            ['id' =>1, 'name' => 'GyZon', 'status'=>1],
            ['id' =>2, 'name' => 'Tee', 'status'=>1],
            ['id' =>3, 'name' => 'Woff', 'status'=>1],
            ['id' =>4, 'name' => 'Turtle', 'status'=>1],
            ['id' =>5, 'name' => 'December', 'status'=>1],
            ['id' =>6, 'name' => 'Viper', 'status'=>1],
            ['id' =>7, 'name' => 'KiliJon', 'status'=>1],

        ];
        Brand::insert($brandRecords);
    }
}
