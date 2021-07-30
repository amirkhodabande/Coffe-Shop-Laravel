<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $orderRequest = [
        "order" => [
            "consume_location" => "in shop",
            "products" => [
                "0" => [
                    "product_id" => "1",
                    "product_options" => [
                        "milk" => "semi",
                        "size" => "small"
                    ]
                ]
            ]
        ]
    ];

    /**
     * Generate a user and log in.
     */
    public function loginAsCustomer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * Check a logged in user can order some product successfully.
     */
    public function test_a_user_can_order_some_product()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Order registered successfully!'
            ]);
    }

    /**
     * Check unauthorized users get correct response, when they want to order.
     */
    public function test_an_unauthorized_user_can_not_order_some_product()
    {
        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /**
     * Check that customers can see their orders.
     */
    public function test_a_customer_can_see_his_order()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->get("/api/order/$orderId")
            ->assertStatus(200);
    }

    /**
     * Check users can only see their own orders.
     */
    public function test_a_customer_can_not_see_other_ones_order()
    {
        Product::factory()->create();

        $this->actingAs(User::factory()->create());

        $this->postJson('/api/order', $this->orderRequest);

        $this->loginAsCustomer();

        $orderId = Order::first()->id;

        $this->get("/api/order/$orderId")
            ->assertStatus(401)
            ->assertJson([
                'message' => 'This is not one of your orders!'
            ]);
    }

    /**
     * Check users are able to cancel their waiting orders.
     */
    public function test_a_customer_can_cancel_his_waiting_order()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->put("/api/cancel-order/$orderId")
            ->assertStatus(202)
            ->assertJson([
                'message' => 'Order canceled successfully.'
            ]);
    }

    /**
     * Check users will get correct response when they tried to cancel a canceled order.
     */
    public function test_a_customer_will_get_correct_response_for_cancelling_canceled_orders()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $order = Order::first();
        $order->update(['status' => 'canceled']);

        $orderId = $order->id;

        $this->put("/api/cancel-order/$orderId")
            ->assertStatus(200)
            ->assertJson([
                'message' => 'The selected order is already canceled!'
            ]);
    }
}
