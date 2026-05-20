<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>Receipt</title>

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 14px;
    color: #333;
}

.container {
    padding: 20px;
}

.header {
    text-align: center;
}

.info p {
    margin: 3px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    border-bottom: 1px solid #ccc;
    padding: 8px;
}

table th {
    background: #f5f5f5;
}

.total {
    text-align: right;
    margin-top: 15px;
    font-weight: bold;
}

.footer {
    text-align: center;
    margin-top: 20px;
    font-size: 12px;
}
</style>

</head>

<body>

<div class="container">

<div class="header">
    <h2>🍽 Culinarilicious Receipt</h2>
</div>

<div class="info">
    <p><b>Order ID:</b> #{{ $order->id }}</p>
    <p><b>Customer:</b> {{ $order->user->name }}</p>
    <p><b>Status:</b> {{ ucfirst($order->status) }}</p>
    <p><b>Date:</b> {{ $order->created_at->format('F d, Y h:i A') }}</p>
</div>

<hr>

<table>
<thead>
<tr>
    <th>Item</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Subtotal</th>
</tr>
</thead>

<tbody>
@foreach($order->items as $item)
<tr>
    <td>{{ $item->food->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>₱{{ number_format($item->price, 2) }}</td>
    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<div class="total">
    Total: ₱{{ number_format($order->total_price, 2) }}
</div>

<div class="footer">
    Thank you for ordering! 🍴
</div>

</div>

</body>
</html>
