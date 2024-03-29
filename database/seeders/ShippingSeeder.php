<?php

namespace Database\Seeders;

use App\Models\Setting\Alamatpengirim;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alamatpengirim::create([
            'city_id' => 103,
            'province_id' => 9,
            'detail_alamat' => '-'
        ]);
    }
}
