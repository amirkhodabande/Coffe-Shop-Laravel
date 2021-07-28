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
        $this->middleware('ownership.check', ['only' => ['get']]);
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
}
