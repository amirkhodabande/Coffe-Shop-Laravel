@component('mail::message')
# Order status

Your order status has been changed to {{ $order->status }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
