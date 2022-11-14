<p>Hello , {{ $adminName }}</p>

<p>A new order has been created (order #{{ $order_id }}) On Product ({{ $product }}) By {{ $name }}</p>

<p><a href="{{ route('show.order', $order_id) }}">Click to view the order</a></p>

<p>Thank you,</p>
