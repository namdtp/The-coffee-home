<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsAttributesRecords = [
            ['id'=>1, 'product_id'=>2, 'size'=>'Small','price'=>'350','stock'=>10,'sku'=>'DST-S','status'=>1],
            ['id'=>2, 'product_id'=>2, 'size'=>'Medium','price'=>'350','stock'=>15,'sku'=>'DST-M','status'=>1],
            ['id'=>3, 'product_id'=>2, 'size'=>'Large','price'=>'350','stock'=>5,'sku'=>'DST-L','status'=>1],       
        ];

        ProductsAttribute::insert($productsAttributesRecords);
    }
}
