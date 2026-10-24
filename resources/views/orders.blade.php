@extends('layouts.default')

@section('content')
<div class="container mt-5">
    <h2>Your Orders</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Order ID</th>
                <th>Payment ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->book_id }}</td>
                <td>{{ $order->id }}</td>
                <td>{{ $order->gateway_payment_id }}</td>
                <td>₹{{ $order->total_price }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
