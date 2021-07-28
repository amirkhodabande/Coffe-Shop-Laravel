<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrderRepositoryInterface {

    public function order(Request $request);

    public function get(Order $order);

}
