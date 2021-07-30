<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatus;
use Tests\TestCase;

class ManagerTest extends TestCase
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
     * Generate a manager and log in.
     */
    public function loginAsManager()
    {
        $user = User::factory(['type' => 'manager'])->create();
        $this->actingAs($user);
    }

    /**
     * Generate a user and log in.
     */
    public function loginAsCustomer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * Check managers are able to change orders status.
     */
    public function test_manager_can_change_orders_status()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->loginAsManager();

        $this->putJson("/api/manager/edit-order/$orderId", [
            "status" => "preparation"
        ])
            ->assertStatus(202);
    }

    /**
     * Check only managers are able to change orders status.
     */
    public function test_only_manager_can_change_orders_status()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->putJson("/api/manager/edit-order/$orderId", [
            "status" => "preparation"
        ])
            ->assertStatus(401);
    }

    /**
     * Check manager get correct response when enters invalid data.
     */
    public function test_manager_receive_correct_response_when_enters_invalid_data()
    {
        $this->loginAsCustomer();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->loginAsManager();

        $this->putJson("/api/manager/edit-order/$orderId", [
            "status" => "invalid status"
        ])
            ->assertStatus(422);
    }

    /**
     * Check customer will get an email when his order's status changed.
     */
    public function test_customer_receive_a_notify_email()
    {
        $this->loginAsCustomer();
        $this->withoutExceptionHandling();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);

        $orderId = Order::first()->id;

        $this->loginAsManager();

        Mail::fake();

        $this->putJson("/api/manager/edit-order/$orderId", [
            "status" => "preparation"
        ])
            ->assertStatus(202);

        Mail::assertSent(OrderStatus::class);
    }

    /**
     * Check customer will not get an email when his order's status not changed.
     *
     * This happens when the given status is similar to the order status.
     */
    public function test_customer_do_not_receive_a_notify_email()
    {
        $this->loginAsCustomer();
        $this->withoutExceptionHandling();

        Product::factory()->create();

        $this->postJson('/api/order', $this->orderRequest);
        $order = Order::first();

        $order->update(['status' => 'ready']);
        $orderId = Order::first()->id;

        $this->loginAsManager();

        Mail::fake();

        $this->putJson("/api/manager/edit-order/$orderId", [
            "status" => "ready"
        ])
            ->assertStatus(202);

        Mail::assertNothingSent(OrderStatus::class);
    }
}
