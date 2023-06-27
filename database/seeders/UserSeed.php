<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeed extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'number_id' => '1122334455',
            'name' => 'Dylan',
            'last_name' => 'Villalba',
            'email' => 'dylanvr97@gmail.com',
            'password' => bcrypt(123456789),
        ]);
    }
}
