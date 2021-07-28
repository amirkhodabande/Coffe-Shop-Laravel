<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productArray = ['Latte', 'Cappuccino', 'Espresso', 'Tea', 'Hot chocolate', 'Cookie'];
        $title = $this->faker->randomElement($productArray) . ' ' . $this->faker->unique()->title();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'price' => $this->faker->numberBetween(30000, 100000)
        ];
    }
}
