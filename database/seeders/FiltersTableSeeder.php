<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filterRecords = [
            ['id'=>1,'cat_ids'=>'1,2,3,6,7,8','filter_name'=>'Fabric','filter_column'=>'fabric','status'=>1],
            ['id'=>2,'cat_ids'=>'4,5','filter_name'=>'Shoes','filter_column'=>'shoes','status'=>1],
            ['id'=>3,'cat_ids'=>'9,10','filter_name'=>'Accessories','filter_column'=>'accessories','status'=>1],
        ];
        ProductsFilter::insert($filterRecords);
    }
}
