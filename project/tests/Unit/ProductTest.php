<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A test for getting info about product sale.
     *
     * @return void
     */
    public function test_can_get_sales_count()
    {
//      Generate some users, products and register an order for first 4 products.
        app(DatabaseSeeder::class)->call(DatabaseSeeder::class);

        $count = Product::first()->getOrdersCountAttribute();

        $this->assertEquals(1, $count);
    }
}
