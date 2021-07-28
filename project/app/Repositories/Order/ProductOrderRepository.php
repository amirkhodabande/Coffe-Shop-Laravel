<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ProductOrderRepository implements OrderRepositoryInterface
{
    /**
     *
     * Each order can have multiple product
     *
     * Each product can have multiple custom options
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request): \Illuminate\Http\Response
    {
        $products = $request['order']['products'];
        $consumeLocation = $request['order']['consume_location'];

//      Register order
        $order = $this->registerOrder($consumeLocation);

//      Attach ordered products
        $this->registerOrderedProductToOptions($products, $order);

//      Calculate price
        $this->calculatePrice($order->products, $order);

//      Make user friendly response
        $finalResponse = $this->finalResponse($order);

        return response(['message' => 'Order registered successfully!', 'data' => $finalResponse]);
    }

    /**
     * @param $consumeLocation
     * @return mixed
     */
    private function registerOrder($consumeLocation): mixed
    {
        return auth()->user()->orders()->create([
            'consume_location' => $consumeLocation,
        ]);
    }

    /**
     * Calculate price
     *
     * @param $products
     * @param $order
     * @return mixed
     */
    private function calculatePrice($products, $order): mixed
    {
        $price = 0;
        foreach ($products as $product) {
            $price += $product->price;
        }
        return $order->update(['price' => $price]);
    }

    /**
     * Create a row of custom selected options
     *
     * Attach ordered products to the options
     *
     * @param $products
     * @param $order
     */
    private function registerOrderedProductToOptions($products, $order)
    {
        $options = [];

//      Save options
        foreach ($products as $product) {
            $options[] = ProductOption::create($product['product_options']);
        }

        $i = 0;
        foreach ($products as $product) {
            Product::find($product['product_id'])->orders()->save($order, ['options_id' => $options[$i]['id']]);
            $i += 1;
        };
    }

    /**
     * Generate a user friendly response
     *
     * @param $order
     * @return array
     */
    #[ArrayShape(['Order' => "mixed", 'Products' => "array"])]
    private function finalResponse($order): array
    {
        $order = Order::find($order['id']);
        return [
            'Order' => [
                'consume_location' => $order['consume_location'],
                'status' => $order['status'],
                'price' => $order['price']
            ],
            'Products' => [
                $order->products()->select('title', 'price')->get()
            ]
        ];
    }
}
