<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderRepositoryInterface $productOrderRepository;

    public function __construct(OrderRepositoryInterface $productOrderRepository)
    {
        $this->productOrderRepository = $productOrderRepository;
        $this->middleware('ownership.check', ['only' => ['get', 'update']]);
    }

    /**
     * Order a product
     *
     * @param Request $request
     */
    public function order(Request $request)
    {
        return $this->productOrderRepository->order($request);
    }

    /**
     * @param Order $order
     */
    public function get(Order $order)
    {
        return $this->productOrderRepository->get($order);
    }

    /**
     * Cancel a customer's order.
     *
     * Changing the status of canceled orders is limited.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order): \Illuminate\Http\Response
    {
        if ($order['status'] !== 'canceled') {

            $order->update(['status' => 'canceled']);
            return response(['message' => 'Order canceled successfully.'], 202);

        }
        return response(['message' => 'The selected order is already canceled!'], 200);
    }
}
