<?php

namespace Database\Factories;

use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'milk' => $this->faker->randomElement(['', 'skim', 'semi', 'whole']),
            'shots' => $this->faker->randomElement(['', 'single', 'double', 'triple']),
            'size' => $this->faker->randomElement(['', 'small', 'medium', 'large']),
            'kind' => $this->faker->randomElement(['', 'chocolate', 'chip', 'ginger']),
        ];
    }
}
