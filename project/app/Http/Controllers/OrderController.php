<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderRepositoryInterface $productOrderRepository;
    public function __construct(OrderRepositoryInterface $productOrderRepository)
    {
        $this->productOrderRepository = $productOrderRepository;
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
}
