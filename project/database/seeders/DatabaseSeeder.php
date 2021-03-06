<?php

namespace Database\Seeders;

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
        User::factory(['email' => 'manager@coffe.com', 'type' => 'manager'])->create();
        $user = User::factory(['email' => 'customer@coffe.com', 'type' => 'customer'])->create();

//      Creating product
        $orderedProducts = Product::factory(4)->create();
        $products = Product::factory(2)->create();

//      Creating some options
        $options = ProductOption::factory()->create();

//       Registering the final order
        $order = $user->orders()->create([
            'consume_location' => 'in shop',
            'status' => 'waiting'
        ]);

        foreach ($orderedProducts as $orderedProduct) {
            $orderedProduct->orders()->save($order, ['options_id' => $options->first()->id]);
        }

        $price = 0;
        foreach ($products as $product) {
            $price += $product->price;
        }
        $order->update(['price' => $price]);
    }
}
