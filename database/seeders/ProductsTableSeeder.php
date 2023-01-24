<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id' => 1,'section_id' =>2,'category_id' =>5,'brand_id' =>7,'vendor_id'=>1,'admin_id'=>0,'admin_type'=>'vendor','product_name'=>'Lụa tơ tằm cao cấp',
            'product_code'=>'LuaCC','product_type'=>'Blue','product_price'=>200000,'product_discount'=>10,'product_weight'=>10,'product_image'=>'',
            'product_video' =>'', 'description'=>'', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'is_featured'=>'Yes', 'status' =>1],
            ['id' => 2,'section_id' =>1,'category_id' =>6,'brand_id' =>2,'vendor_id'=>0,'admin_id'=>1,'admin_type'=>'superadmin','product_name'=>'Dragon T-Shirt',
            'product_code'=>'DTS','product_type'=>'Black','product_price'=>300,'product_discount'=>5,'product_weight'=>10,'product_image'=>'',
            'product_video' =>'', 'description'=>'', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'is_featured'=>'Yes', 'status' =>1],
        ];
        Product::insert($productRecords);
    }
}
