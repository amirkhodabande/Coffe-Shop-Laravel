<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatus;
use App\Models\Order;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Mail;

class ManagerController extends Controller
{
    /**
     * Change orders status.
     *
     * Changing the status of canceled orders is limited.
     *
     * @param Order $order
     * @param OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order, OrderRequest $request): \Illuminate\Http\Response
    {
        if ($order['status'] !== 'canceled') {
            $order->update(['status' => $request['status']]);
            $this->sendMail($order);
            return ($request['status'] == "canceled")
                ?
                response("Order canceled successfully.", 202)
                :
                response("Order status successfully updated to " . $request['status'] . ".", 202);
        } else
            return response("You are not able to change the Canceled orders status.", 200);
    }

    /**
     * Notify user via email.
     *
     * @param $order
     */
    private function sendMail($order)
    {
        Mail::to($order->user->email)->send(new OrderStatus($order));
    }
}
