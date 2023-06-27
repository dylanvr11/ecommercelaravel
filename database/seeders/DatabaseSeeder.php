<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use Database\Seeders\UserSeed;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeed;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            UserSeed::class,
            CategorySeed::class
        ]);

        User::factory(10)->create();
        Product::factory(100)->create();
    }
}
