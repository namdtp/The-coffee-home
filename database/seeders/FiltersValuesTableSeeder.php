<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFiltersValue;

class FiltersValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filtervalueRecords = [
            ['id' => 1,'filter_id'=>1,'filter_value'=>'cotton','status'=>1],
            ['id' => 2,'filter_id'=>1,'filter_value'=>'polyester','status'=>1],
            ['id' => 3,'filter_id'=>2,'filter_value'=>'genuine leather','status'=>1],
            ['id' => 4,'filter_id'=>2,'filter_value'=>'leatherette','status'=>1],
            ['id' => 5,'filter_id'=>3,'filter_value'=>'silver','status'=>1],
            ['id' => 6,'filter_id'=>3,'filter_value'=>'stell','status'=>1],            
        ];
        ProductsFiltersValue::insert($filtervalueRecords);
    }
}
