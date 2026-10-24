@extends('layouts.admin')

@push('title', get_phrase('Orders'))

@push('meta')
<!-- Add any meta information if needed -->
@endpush

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    @media print {
        .print-d-none { display: none !important; }
    }
</style>
@endpush

@section('content')
<!-- Header with title -->
<div class="ol-card radius-8px print-d-none">
    <div class="ol-card-body my-3 py-4 px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi fi-br-clipboard-list me-2"></i>
                <span>{{ get_phrase('Order') }}</span>
            </h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">
                <!-- Export & Search -->
                <div class="row print-d-none mb-3 mt-3 row-gap-3">
                    <!-- Export -->
                    <div class="col-md-6 pt-2 pt-md-0">
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }} <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'orders')">
                                        <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'orders')">
                                        <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print();">
                                        <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="col-md-6">
                        <form action="{{ route('admin.orders') }}" method="get">
                            <div class="row row-gap-3">
                                <div class="col-md-9">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Orders') }}" class="ol-form-control form-control" />
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn ol-btn-primary px-2 w-100">
                                        {{ get_phrase('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.transaction_tabs')

                @php
                    $contactInfo = json_decode(get_frontend_settings('contact_info'), true);
                @endphp

                <!-- Table -->
                @if($orders->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . $orders->count() . ' ' . get_phrase('of') . ' ' . $orders->total() . ' ' . get_phrase('orders') }}
                        </p>
                    </div>
                    <div class="table-responsive order_list" id="order_list">
                        <table id="ordersTable" class="table eTable eTable-2 print-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('User') }}</th>
                                    <th>{{ get_phrase('Book') }}</th>
                                    <th>{{ get_phrase('Quantity') }}</th>
                                    <th>{{ get_phrase('Total Price') }}</th>
                                    <th>{{ get_phrase('Invoice') }}</th>
                                    <th>{{ get_phrase('Shipping Status') }}</th>
                                    <th class="print-d-none">{{ get_phrase('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ ucwords($order->user->name ?? 'N/A') }}</td>
                                    <td>{{ $order->book->title ?? 'N/A' }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>₹{{ number_format($order->total_price, 2) }}</td>
                                    <td class="print-d-none">
                                        <button class="btn btn-sm btn-warning mt-1 generate-invoice"
                                            data-id="{{ $order->id }}"
                                            data-shippingname="{{ !empty($order->shipping_name) ? $order->shipping_name : ($order->user?->name ?? 'N/A') }}"
                                            data-shippingemail="{{ !empty($order->shipping_email) ? $order->shipping_email : ($order->user?->email ?? 'N/A') }}"
                                            data-phone="{{ $order->shipping_contact ?? 'N/A' }}"
                                            data-address="{{ $order->shipping_address ?? 'N/A' }}"
                                            data-fulladdress="{{ is_array($order->full_shippingaddress)
                                                    ? implode(', ', array_filter($order->full_shippingaddress))
                                                    : ($order->full_shippingaddress ?? 'N/A') }}"
                                            data-book="{{ $order->book->title ?? 'N/A' }}"
                                            data-shipping_status="{{ $order->shipping_status ?? 'N/A' }}"
                                            data-quantity="{{ $order->quantity }}"
                                            data-total="₹{{ number_format($order->total_price, 2) }}"
                                            data-paymenttype="{{ ucfirst($order->payment_type ?? 'N/A') }}"
                                            data-payment="{{ ucfirst($order->payment_status ?? 'unpaid') }}"
                                            data-status="{{ ucfirst($order->status ?? 'pending') }}"
                                            data-date="{{ $order->created_at->format('d M Y, h:i A') }}">
                                            <i class="fi fi-rr-file-invoice"></i> Invoice
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.updateShippingStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select
                                                name="shipping_status"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()"
                                                {{ $order->shipping_status == 'delivered' ? 'disabled' : '' }}
                                            >
                                                <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->shipping_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="print-d-none">
                                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <span class="fi fi-rr-menu-dots-vertical"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewOrderModal"
                                                    data-id="{{ $order->id }}"
                                                    data-phone="{{ $order->shipping_contact ?? 'N/A' }}"
                                                    data-shippingname="{{ !empty($order->shipping_name) ? $order->shipping_name : ($order->user?->name ?? 'N/A') }}"
                                                    data-shippingemail="{{ !empty($order->shipping_email) ? $order->shipping_email : ($order->user?->email ?? 'N/A') }}"
                                                    data-address="{{ $order->shipping_address ?? 'N/A' }}"
                                                    data-fulladdress="{{ is_array($order->full_shippingaddress)
                                                            ? implode(', ', array_filter($order->full_shippingaddress))
                                                            : ($order->full_shippingaddress ?? 'N/A') }}"
                                                    data-book="{{ $order->book->title ?? 'N/A' }}"
                                                    data-quantity="{{ $order->quantity }}"
                                                    data-paymenttype="{{ $order->payment_type }}"
                                                    data-gateway_order_id="{{ $order->gateway_order_id }}"
                                                    data-gateway_payment_id="{{ $order->gateway_payment_id }}"
                                                    data-total="₹{{ number_format($order->total_price, 2) }}"
                                                    data-status="{{ ucfirst($order->status ?? 'pending') }}"
                                                    data-payment="{{ ucfirst($order->payment_status ?? 'unpaid') }}"
                                                    data-shipping="{{ ucfirst($order->shipping_status ?? 'pending') }}"
                                                    data-created="{{ $order->created_at->format('d M Y, h:i A') }}"
                                                    href="javascript:void(0)">
                                                        <i class="fi fi-rr-eye me-1"></i> {{ get_phrase('View') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="font-weight:bold;background:#f5f5f5">
                                    <td colspan="4" class="text-end">
                                        {{ get_phrase('Total') }} :
                                    </td>
                                    <td>
                                        ₹{{ number_format($orders->sum('total_price'), 2) }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    @include('admin.no_data')
                @endif

                <!-- Pagination -->
                @if ($orders->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15 mt-3">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . $orders->count() . ' ' . get_phrase('of') . ' ' . $orders->total() . ' ' . get_phrase('orders') }}
                        </p>
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Invoice Preview Modal -->
<div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-labelledby="invoicePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Order Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invoicePreviewContent" style="font-family: Arial; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button id="downloadInvoiceBtn" class="btn btn-success">Download PDF</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ get_phrase('Order Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ get_phrase('Close') }}"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>{{ get_phrase('Order ID') }}</th>
                        <td id="view_id"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Name') }}</th>
                        <td id="view_shippingname"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Email') }}</th>
                        <td id="view_shippingemail"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Phone') }}</th>
                        <td id="view_phone"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('UserAddress') }}</th>
                        <td id="view_address"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Full Address') }}</th>
                        <td id="view_fulladdress"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Book') }}</th>
                        <td id="view_book"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Quantity') }}</th>
                        <td id="view_quantity"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Payment Type') }}</th>
                        <td id="view_paymenttype"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Total Price') }}</th>
                        <td id="view_total"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Order Status') }}</th>
                        <td id="view_status"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Payment Status') }}</th>
                        <td id="view_payment"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Payment Order ID') }}</th>
                        <td id="view_payment_order_id"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Payment ID') }}</th>
                        <td id="view_payment_id"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Shipping Status') }}</th>
                        <td id="view_shipping"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Order Date & Time') }}</th>
                        <td id="view_created"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, targets: [5, 7] }
            ],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                let total = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce((a, b) => {
                        let num = parseFloat(b.replace(/[^\d.-]/g, '')) || 0;
                        return a + num;
                    }, 0);
                $(api.column(4).footer()).html(
                    '₹' + total.toFixed(2)
                );
            }
        });
    });

    function downloadPDF(selector, filename) {
        const element = document.querySelector(selector);
        if (!element) {
            alert('Table not found!');
            return;
        }
        const opt = {
            margin: 1,
            filename: filename + '_' + new Date().toISOString().slice(0, 10) + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 }
        };
        html2pdf().set(opt).from(element).save();
    }

    function exportToExcel(selector, filename) {
        const table = document.querySelector(selector);
        if (!table) {
            alert('Table not found!');
            return;
        }
        let data = [];
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('th, td');
            cells.forEach(cell => rowData.push(cell.innerText));
            data.push(rowData);
        });
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, filename + '.xlsx');
    }
</script>
<script>
    const viewOrderModal = document.getElementById('viewOrderModal');
    viewOrderModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('view_id').innerText = button.getAttribute('data-id');
        document.getElementById('view_shippingname').innerText = button.getAttribute('data-shippingname');
        document.getElementById('view_shippingemail').innerText = button.getAttribute('data-shippingemail');
        document.getElementById('view_phone').innerText = button.getAttribute('data-phone');
        document.getElementById('view_address').innerText = button.getAttribute('data-address');
        document.getElementById('view_fulladdress').innerText = button.getAttribute('data-fulladdress');
        document.getElementById('view_book').innerText = button.getAttribute('data-book');
        document.getElementById('view_quantity').innerText = button.getAttribute('data-quantity');
        document.getElementById('view_paymenttype').innerText = button.getAttribute('data-paymenttype');
        document.getElementById('view_total').innerText = button.getAttribute('data-total');
        document.getElementById('view_status').innerText = button.getAttribute('data-status');
        document.getElementById('view_payment').innerText = button.getAttribute('data-payment');
        document.getElementById('view_payment_order_id').innerText = button.getAttribute('data-gateway_order_id');
        document.getElementById('view_payment_id').innerText = button.getAttribute('data-gateway_payment_id');
        document.getElementById('view_shipping').innerText = button.getAttribute('data-shipping');
        document.getElementById('view_created').innerText = button.getAttribute('data-created');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoicePreviewModal = new bootstrap.Modal(document.getElementById('invoicePreviewModal'));
        const invoiceContentDiv = document.getElementById('invoicePreviewContent');
        let currentInvoiceData = null;

        document.querySelectorAll('.generate-invoice').forEach(button => {
            button.addEventListener('click', function() {
                currentInvoiceData = {
                    id: this.dataset.id,
                    shippingname: this.dataset.shippingname,
                    shippingemail: this.dataset.shippingemail,
                    phone: this.dataset.phone,
                    address: this.dataset.address,
                    fulladdress: this.dataset.fulladdress,
                    shipping_status: this.dataset.shipping_status,
                    book: this.dataset.book,
                    quantity: this.dataset.quantity,
                    total: this.dataset.total,
                    paymenttype: this.dataset.paymenttype,
                    payment: this.dataset.payment,
                    status: this.dataset.status,
                    date: this.dataset.date
                };

                const invoiceHTML = `
                    <div class="container">
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-6">
                                        <p><strong>Order ID:</strong> #${currentInvoiceData.id}</p>
                                        <p><strong>Date:</strong> ${currentInvoiceData.date}</p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <img src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="logo" width="150">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3 text-black">
                                    <div class="col-md-6">
                                        <h4 class="mb-3">Company Details</h4>
                                        <p class="mt-2 mb-0"><strong>Name:</strong> {{ get_settings('system_name') }}</p>
                                        <p class="mb-0"><strong>Email:</strong> {{ $contactInfo['email'] ?? 'N/A' }}</p>
                                        <p class="mb-0"><strong>Phone:</strong> {{ $contactInfo['phone'] ?? 'N/A' }}</p>
                                        <p class="mb-0"><strong>Address:</strong> {{ $contactInfo['address'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-3">Customer Details</h4>
                                        <p><strong>Name:</strong> ${currentInvoiceData.shippingname}</p>
                                        <p><strong>Email:</strong> ${currentInvoiceData.shippingemail}</p>
                                        <p><strong>Phone:</strong> ${currentInvoiceData.phone}</p>
                                        <p><strong>Address:</strong> ${currentInvoiceData.fulladdress}</p>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="mb-3">Order Details</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="fw-semibold">Book</th>
                                                <th class="fw-semibold text-center" width="120">Quantity</th>
                                                <th class="fw-semibold text-end" width="120">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>${currentInvoiceData.book}</td>
                                                <td class="text-center">${currentInvoiceData.quantity}</td>
                                                <td class="text-end">${currentInvoiceData.total}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 offset-md-4">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <strong class="fs-5">Total:</strong>
                                                <strong class="fs-5 text-primary">${currentInvoiceData.total}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <p><strong>Shipping Status:</strong> <span class="badge bg-primary">${currentInvoiceData.shipping_status}</span></p>
                                    </div>
                                </div>
                                <div class="text-center mt-4 pt-3 border-top">
                                    <p class="text-muted mb-0">Thank you for shopping with us!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                invoiceContentDiv.innerHTML = invoiceHTML;
                invoicePreviewModal.show();
            });
        });

        document.getElementById('downloadInvoiceBtn').addEventListener('click', async function() {
            if (!currentInvoiceData) return;
            const { jsPDF } = window.jspdf;
            const tempDiv = invoiceContentDiv.cloneNode(true);
            tempDiv.style.width = '700px';
            document.body.appendChild(tempDiv);
            const canvas = await html2canvas(tempDiv, { scale: 2 });
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'pt', 'a4');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save(`invoice_${currentInvoiceData.id}.pdf`);
            document.body.removeChild(tempDiv);
        });
    });
</script>
@endpush
