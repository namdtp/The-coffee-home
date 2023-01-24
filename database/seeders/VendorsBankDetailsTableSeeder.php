<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=>'Ly Huu Dat','bank_name'=>'ACB','account_number'=>'10313529','bank_ifsc_code'=>'ASCBVNVX']
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
