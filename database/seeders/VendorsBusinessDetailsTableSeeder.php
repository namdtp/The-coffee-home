<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'Dat Clothing Store','shop_address'=>'134 Tran Ba Giao','shop_city'=>'TPHCM',
            'shop_state'=>'','shop_country'=>'VietNam','shop_pincode'=>'74000','shop_mobile'=>'01869869518','shop_website'=>'fb.com/Sune1012',
            'shop_email'=>'lyhuudat9a4@gmail.com','address_proof'=>'CCCD','address_proof_image'=>'test.jpg','business_license_number'=>'12345678',
            'gst_number'=>'12334455','pan_number'=>'2344235512']
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
