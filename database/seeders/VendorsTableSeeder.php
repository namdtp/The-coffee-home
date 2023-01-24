<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecord = [
            ['id'=> 1,'name'=> 'Dat','address'=> '134 Tran Ba Giao','city'=> 'TP.HCM','state'=>'','country'=> 'VietNam'
            ,'pincode'=> '74000','mobile'=> '01869869518','email'=> 'lyhuudat9a4@gmail.com','status'=> 0],
        ];
        Vendor::insert($vendorRecord);
    }
}
