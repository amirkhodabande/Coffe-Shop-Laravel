<?php

namespace App\Repositories\Order;

use Illuminate\Http\Request;

interface OrderRepositoryInterface {

    /**
     * @param Request $request
     */
    public function order(Request $request);

}
