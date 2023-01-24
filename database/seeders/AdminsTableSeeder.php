<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            ['id' => 1, 'name' => 'Diep Ha', 'type' => 'superadmin', 'vendor_id' => 0, 'mobile' => '0918496855'
                , 'email' => 'dieptuha2001@gmail.com', 'password' => '$2a$12$My1OCLVlfYf1K373KrCCaOHx2Dzu7Wddznr6g2CNvx.Wso0u1JWVa'
                , 'image' => '', 'status' => 1],
        ];
        Admin::insert($adminRecords);
    }
}
