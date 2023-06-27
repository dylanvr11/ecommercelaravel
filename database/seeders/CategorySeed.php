<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    public function run()
    {
        //1
        DB::table('categories')->insert([
            'name' => 'Electrónica',
        ]);
        //2
        DB::table('categories')->insert([
            'name' => 'Ropa y moda',
        ]);
        //3
        DB::table('categories')->insert([
            'name' => 'Hogar y jardín',
        ]);
        //4
        DB::table('categories')->insert([
            'name' => 'Salud y belleza',
        ]);
        //5
        DB::table('categories')->insert([
            'name' => 'Deportes',
        ]);
    }
}
