@extends('layouts.default')
@push('title', get_phrase('My profile'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

<div class="container py-5">
    <div class="row">
        @include('frontend.default.student.left_sidebar')
                 @php
                    $contactInfo = json_decode(get_frontend_settings('contact_info'), true);
                @endphp
        <div class="col-lg-9 px-4">
            <h2 class="g-title mb-5">Your Orders</h2>
            <div class="my-panel purchase-history-panel">
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>Book Name</th>
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>Amount</th>
                                <th>Shipping Status</th>
                                <!--<th>Order Status</th>-->
                                <!--<th>Payment Status</th>-->
                                <th>Date</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->book->title ?? 'N/A' }}</td>
                                    <td>{{ $order->id ?? 'N/A' }}</td>
                                    <td>{{ $order->gateway_payment_id ?? 'N/A' }}</td>
                                    <td>₹{{ number_format($order->total_price ?? 0, 2) }}</td>
                                    <td>{{ ucfirst($order->shipping_status ?? 'N/A') }}</td>
                                    <!--<td>{{ ucfirst($order->status ?? 'N/A') }}</td>-->
                                    <!--<td>{{ ucfirst($order->payment_status ?? 'N/A') }}</td>-->
                                    <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-lg btn-primary invoice-btn" 
                                            data-book="{{ $order->book->title ?? 'N/A' }}" 
                                            data-order="{{ $order->id ?? 'N/A' }}" 
                                            data-quantity="{{ $order->quantity ?? 1 }}" 
                                            data-amount="{{ number_format($order->total_price ?? 0, 2) }}" 
                                            data-payment="{{ $order->payment_type ?? 'N/A' }}"
                                            data-paymentstatus="{{ $order->payment_status ?? 'N/A' }}"
                                            data-shippingstatus="{{ $order->shipping_status ?? 'N/A' }}"
                                            data-paymentid="{{ $order->gateway_payment_id ?? 'N/A' }}" 
                                            data-date="{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') : 'N/A' }}"
                                            data-user="{{ $order->user->name ?? 'N/A' }}"
                                            data-email="{{ $order->user->email ?? 'N/A' }}"
                                            data-phone="{{ $order->user->phone ?? 'N/A' }}"
                                            data-address='@json($order->full_shippingaddress ?? [])'>
                                            Invoice
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="invoiceContent">
                <!-- Invoice HTML will be injected here by JS -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-lg" onclick="printInvoice()">Download / Print</button>
                <button class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
/*
document.addEventListener('DOMContentLoaded', function() {
    const invoiceButtons = document.querySelectorAll('.invoice-btn');
    const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
    const invoiceContent = document.getElementById('invoiceContent');

    invoiceButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const book = btn.dataset.book || 'N/A';
            const orderId = btn.dataset.order || 'N/A';
            const quantity = btn.dataset.quantity || 1;
            const amount = btn.dataset.amount || 0;
            const payment = btn.dataset.payment || 'N/A';
            const shippingStatus = btn.dataset.shippingstatus || 'N/A';
            const paymentId = btn.dataset.paymentid || 'N/A';
            const date = btn.dataset.date || 'N/A';
            const user = btn.dataset.user || 'N/A';
            const email = btn.dataset.email || 'N/A';
            const phone = btn.dataset.phone || 'N/A';
            const address = JSON.parse(btn.dataset.address || '{}');

            invoiceContent.innerHTML = `
                <h3 style="text-align:center;">Invoice</h3>
                <p><strong>Invoice ID:</strong> ${orderId}</p>
                <p><strong>Date:</strong> ${date}</p>
                <hr>
                <h5>Customer Details</h5>
                <p><strong>Name:</strong> ${user}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Phone:</strong> ${phone}</p>
                <p><strong>Shipping Status:</strong> ${shippingStatus}</p>
                <p><strong>Shipping Address:</strong><br>
                    ${address.address || 'N/A'}, ${address.city || 'N/A'}, ${address.state || 'N/A'}, ${address.country || 'N/A'} - ${address.zipcode || 'N/A'}
                </p>
                
                <hr>
                <h5>Order Details</h5>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <th style="border:1px solid #ccc; padding:5px;">Book</th>
                        <th style="border:1px solid #ccc; padding:5px;">Quantity</th>
                        <th style="border:1px solid #ccc; padding:5px;">Amount</th>
                    </tr>
                    <tr>
                        <td style="border:1px solid #ccc; padding:5px;">${book}</td>
                        <td style="border:1px solid #ccc; padding:5px;">${quantity}</td>
                        <td style="border:1px solid #ccc; padding:5px;">₹${amount}</td>
                    </tr>
                </table>
                <h5 style="text-align:right;">Total: ₹${amount}</h5>
                <hr>
                <p><strong>Payment Type:</strong> ${payment}</p>
                <p><strong>Payment ID:</strong> ${paymentId}</p>
                <p style="margin-top:20px;">Thank you for your purchase!</p>
            `;

            invoiceModal.show();
        });
    });
});
function printInvoice() {
    const content = document.getElementById('invoiceContent').innerHTML;
    const win = window.open('', '', 'height=700,width=900');
    win.document.write('<html><head><title>Invoice</title></head><body>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}
*/

document.addEventListener('DOMContentLoaded', function() {
    const invoiceButtons = document.querySelectorAll('.invoice-btn');
    const invoiceModalElement = document.getElementById('invoiceModal');
    const invoiceModal = new bootstrap.Modal(invoiceModalElement);
    const invoiceContent = document.getElementById('invoiceContent');
    
    invoiceButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const book = btn.dataset.book || 'N/A';
            const orderId = btn.dataset.order || 'N/A';
            const quantity = btn.dataset.quantity || 1;
            const amount = btn.dataset.amount || 0;
            const payment = btn.dataset.payment || 'N/A';
            const paymentstatus = btn.dataset.paymentstatus || 'N/A';
            const shippingStatus = btn.dataset.shippingstatus || 'N/A';
            const paymentId = btn.dataset.paymentid || 'N/A';
            const date = btn.dataset.date || 'N/A';
            const user = btn.dataset.user || 'N/A';
            const email = btn.dataset.email || 'N/A';
            const phone = btn.dataset.phone || 'N/A';
            const address = JSON.parse(btn.dataset.address || '{}');
            
            // Get shipping status badge class
            const statusBadge = getStatusBadge(shippingStatus);
            
            invoiceContent.innerHTML = `
                <div class="invoice-wrapper p-4">
                    <!-- Invoice Header -->
                    <div class="row mb-5 align-items-center">
                        <div class="col-md-6">
                            <h2 class="fw-bold text-color mb-1">INVOICE</h2>
                            <p class="text-muted mb-0">Thank you for your purchase</p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <img src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="logo" width="150">
                        </div>
                    </div>
                   
                    <!-- Invoice Meta -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong class="text-dark">Invoice ID:</strong> <span class="text-muted">${orderId}</span></p>
                            <p class="mb-1"><strong class="text-dark">Date:</strong> <span class="text-muted">${date}</span></p>
                            <p class="mb-0"><strong class="text-dark">Payment ID:</strong> <span class="text-muted">${paymentId}</span></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge ${statusBadge} fs-6 px-3 py-2">${shippingStatus}</span>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Customer Details -->
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-dark mb-4 fw-semibold">
                                    <i class="fi-rr-user me-2"></i> Company Details
                                </h4>
                                <p class="mt-2 mb-0"><strong>Name:</strong> {{ get_settings('system_name') }}</p>
                                <p class="mb-0"><strong>Email:</strong> {{ $contactInfo['email'] ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Phone:</strong> {{ $contactInfo['phone'] ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Address:</strong> {{ $contactInfo['address'] ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-dark mb-4 fw-semibold">
                                    <i class="fi-rr-user me-2"></i> Customer Details
                                </h4>
                                <p class="mb-2"><strong>Name:</strong> ${user}</p>
                                <p class="mb-2"><strong>Email:</strong> ${email}</p>
                                <p class="mb-0"><strong>Phone:</strong> ${phone}</p>
                                <div>
                                    <p class="mb-2"><strong>Shipping Address:</strong></p>
                                    <address class="text-muted">
                                        ${address.address || 'N/A'}
                                        ${address.city || 'N/A'}, ${address.state || 'N/A'}
                                        ${address.country || 'N/A'} - ${address.zipcode || 'N/A'}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Order Details -->
                    <div class="mb-4">
                        <h4 class="text-dark mb-4 fw-semibold">
                            <i class="fi-rr-shopping-cart-check me-2"></i>Order Details
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Book</th>
                                        <th class="fw-semibold text-center" width="120">Quantity</th>
                                        <th class="fw-semibold text-end" width="150">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${book}</td>
                                        <td class="text-center">${quantity}</td>
                                        <td class="text-end">₹${parseFloat(amount).toFixed(2)}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Total Section -->
                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal:</span>
                                        <span>₹${parseFloat(amount).toFixed(2)}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <strong class="fs-5">Total:</strong>
                                        <strong class="fs-5 text-primary">₹${parseFloat(amount).toFixed(2)}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Payment Info -->
                    <div class="mb-3">
                        <h5 class="text-dark mb-3 fw-semibold">
                            <i class="fi-rr-credit-card me-2"></i>Payment Information
                        </h5>
                     <p class="mb-1"><strong>Payment Method:</strong> <span class="badge bg-success">${payment}</span></p>
                     <p class="mb-1"><strong>Payment Status:</strong> <span class="badge bg-success">${paymentstatus}</span></p>
                    </div>
                    
                    <!-- Footer -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">Thank you for shopping with us!</p>
                    </div>
                </div>
            `;
            
            invoiceModal.show();
        });
    });
    
    // Helper function to get status badge class
    function getStatusBadge(status) {
        const statusLower = status.toLowerCase();
        if (statusLower.includes('delivered') || statusLower.includes('completed')) {
            return 'bg-success';
        } else if (statusLower.includes('shipped') || statusLower.includes('transit')) {
            return 'bg-info';
        } else if (statusLower.includes('processing') || statusLower.includes('pending')) {
            return 'bg-warning text-dark';
        } else if (statusLower.includes('cancelled') || statusLower.includes('failed')) {
            return 'bg-danger';
        } else {
            return 'bg-secondary';
        }
    }
});

function printInvoice() {
    const content = document.getElementById('invoiceContent').innerHTML;
    const win = window.open('', '', 'height=700,width=900');
    win.document.write(`
        <html>
        <head>
            <title>Invoice</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
            <style>
                @media print {
                    body { margin: 0; padding: 20px; }
                    .invoice-wrapper { max-width: 800px; margin: 0 auto; }
                }
                body { font-family: Arial, sans-serif; }
            </style>
        </head>
        <body>
            ${content}
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() {
                        window.close();
                    };
                };
            <\/script>
        </body>
        </html>
    `);
    win.document.close();
}


</script>

@endsection
