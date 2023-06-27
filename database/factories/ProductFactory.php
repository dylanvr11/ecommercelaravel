<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'name' => $this->faker->sentence(),
            'stock' => $this->faker->randomDigit(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomNumber(5, true),
        ];
    }

}
