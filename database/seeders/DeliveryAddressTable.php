<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1,'user_id'=>2,'name'=>'Huu Dat','address'=>'123-a','city'=>'TP-HCM','state'=>'Go Vap','country'=>'Vietnam','pincode'=>720000,
            'mobile'=>'098212549','status'=>1],
            ['id'=>2,'user_id'=>2,'name'=>'Huu Dat','address'=>'123-b','city'=>'TPHCM','state'=>'Tan Phu','country'=>'Vietnam','pincode'=>720010,
            'mobile'=>'098212523','status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
