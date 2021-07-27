<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(['email' => 'manager@coffe.malltina', 'type' => 'manager'])->create();

//      Creating product
        $products = Product::factory(6)->create();

//      Creating some options
        $options = ProductOption::factory()->create();

//       Registering the final order
        Order::factory(['product_id' => $products->first()->id, 'options_id' => $options->first()->id])->create();
    }
}
