@extends('layouts.admin')
@push('title', get_phrase('Payment History'))
@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-4 px-20px">
        <h4 class="title fs-16px"><i class="fi-rr-settings-sliders me-2"></i>{{ get_phrase('Payment History') }}</h4>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        
        <div class="row print-d-none mb-3 mt-3 row-gap-3">
            <div class="col-md-6  pt-2 pt-md-0">
                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>
                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'payment-history')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                        </li>
                         <li>
                            <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'payment-history')">
                                <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <form class="form-inline" action="{{ route('admin.payment.history') }}" method="get">
                    <div class="row row-gap-3">
                        <div class="col-md-9">
                            <input type="text" class="form-control ol-form-control" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Payment History') }}" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn ol-btn-primary w-100" id="submit-button"> {{ get_phrase('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.transaction_tabs')

        <div class="row mb-3">
             <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                    <form action="{{ route('admin.payment.history') }}" method="GET" class="d-flex flex-wrap align-items-end gap-2">

                        <div>
                            <label for="start_date" class="form-label mb-1">{{ get_phrase('From Date') }}</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>

                        <div>
                            <label for="end_date" class="form-label mb-1">{{ get_phrase('To Date') }}</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary mt-3">{{ get_phrase('Filter') }}</button>
                            <a href="{{ route('admin.payment.history') }}" class="btn btn-secondary mt-3">{{ get_phrase('Reset') }}</a>
                        </div>

                    </form>
                </div>
        </div>

        @if(count($reports) > 0)
            <div class="table-responsive">
                <table id="paymentHistoryTable" class="table eTable eTable-2 print-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>OrderId</th>
                            <th>Reference</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <!--<th>Payment Method</th>-->
                            <th>Transaction ID</th>
                            <th>Payment At</th>
                           
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $key => $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--<img class="rounded-circle me-2" width="40" height="40"-->
                                        <!--     src="{{ $report->user_photo && file_exists(public_path($report->user_photo)) ? asset($report->user_photo) : asset('uploads/users/student/placeholder/placeholder.PNG') }}">-->
                                        <span>{{ ucwords($report->user_name) }}</span>
                                    </div>
                                </td>
                                <td>{{ $report->order_id ??  '-' }}</td>
                                <td>{{ $report->refrence ?? '-' }}</td>
                                <td>{{ currency($report->amount) }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->status == 'success' ? 'success' : 'danger' }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <!--<td>{{ $report->gateway }}</td>-->
                                <td>{{ $report->payment_id }}</td>
                                <td>{{ date('d-M-Y H:i', strtotime($report->created_at)) }}</td>
                                @php
                                    // Decode address JSON safely
                                    $addressData = json_decode($report->full_address, true);
                                
                                    $addressText = 'N/A';
                                    if (!empty($addressData)) {
                                        // Fetch related names via facades/models
                                        $cityName = \DB::table('cities')->where('id', $addressData['city'] ?? null)->value('name');
                                        $stateName = \DB::table('states')->where('id', $addressData['state'] ?? null)->value('name');
                                        $countryName = \DB::table('countries')->where('id', $addressData['country'] ?? null)->value('name');
                                
                                        // Build formatted address
                                        $addressText = trim(($addressData['address'] ?? '') . ', ' . 
                                            ($cityName ?? '') . ', ' . 
                                            ($stateName ?? '') . ', ' . 
                                            ($countryName ?? '') . 
                                            (!empty($addressData['zipcode']) ? ' - ' . $addressData['zipcode'] : ''));
                                    }
                                @endphp
                                   
                                        
    
                                <td  class="print-d-none" > <button class="btn btn-sm btn-warning mt-1 generate-invoice"
                                    data-id="{{ $report->order_id }}"
                                    data-user_name="{{ $report->user_name ?? 'N/A' }}"
                                    data-email="{{ $report->email ?? 'N/A' }}"
                                    data-phone="{{ $report->phone ?? 'N/A' }}"
                                    data-full_address="{{ $addressText ?? 'N/A' }}"
                                    data-amount="{{ currency($report->amount) ?? 'N/A' }}"
                                    data-payment_id="{{ $report->payment_id ?? 'N/A' }}"
                                    data-status="{{ ucfirst($report->status) ?? 'N/A'}}"
                                    data-refrence="{{ $report->refrence }}"
                                    data-date="{{ date('d-M-Y H:i', strtotime($report->created_at)) }}">
                                    <i class="fi fi-rr-file-invoice"></i> Invoice
                                </button>  </td>
                                
                                 <td><form action="{{ route('admin.payments.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mt-1">
                                        <i class="fi fi-rr-trash"></i> Delete
                                    </button>
                                </form></td>
                               


                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
            
            <!-- Invoice Preview Modal -->
            <div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-labelledby="invoicePreviewModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Invoice Preview</h5>
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
            
            <!-- View Details Modal -->
            <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Order Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="orderDetailsContent"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        @else
            @include('admin.no_data')
        @endif
    </div>
</div>
@endsection

@push('js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const invoicePreviewModal = new bootstrap.Modal(document.getElementById('invoicePreviewModal'));
    const invoiceContentDiv = document.getElementById('invoicePreviewContent');
    let currentInvoiceData = null;

    document.querySelectorAll('.generate-invoice').forEach(button => {
        button.addEventListener('click', function() {
            // Collect only relevant data from button
            currentInvoiceData = {
                id: this.dataset.id,
                user_name: this.dataset.user_name,
                email: this.dataset.email,
                phone: this.dataset.phone,
                full_address: this.dataset.full_address,
                amount: this.dataset.amount,
                payment_id: this.dataset.payment_id,
                status: this.dataset.status,
                refrence: this.dataset.refrence,
                date: this.dataset.date
            };

            // Generate invoice HTML
            const invoiceHTML = `
                <div style="padding:20px; border:1px solid #ccc;">
                    <h2 style="text-align:center;">📄 Payment Invoice</h2>
                    <hr>
                    <p><strong>Order ID:</strong> ${currentInvoiceData.id}</p>
                    <p><strong>Date:</strong> ${currentInvoiceData.date}</p>
                    <hr>
                    <h4>Customer Details</h4>
                    <p><strong>Name:</strong> ${currentInvoiceData.user_name}</p>
                    <p><strong>Email:</strong> ${currentInvoiceData.email}</p>
                     <p><strong>Phone:</strong> ${currentInvoiceData.phone}</p>
                    <p><strong>Address:</strong> ${currentInvoiceData.full_address}</p>
                    <hr>
                    <h4>Payment Details</h4>
                    <p><strong>Payment ID:</strong> ${currentInvoiceData.payment_id}</p>
                    <p><strong>Reference:</strong> ${currentInvoiceData.refrence}</p>
                    <p><strong>Status:</strong> ${currentInvoiceData.status}</p>
                    <h3 style="text-align:right;">Amount: ${currentInvoiceData.amount}</h3>
                    <hr>
                    <p style="text-align:center;">Thank you for your payment!</p>
                </div>
            `;

            invoiceContentDiv.innerHTML = invoiceHTML;
            invoicePreviewModal.show();
        });
    });

    // PDF download logic
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsModal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
    const orderDetailsDiv = document.getElementById('orderDetailsContent');

    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', function() {
            const cartItems = JSON.parse(this.dataset.cart_items || '[]');
            const userName = this.dataset.user_name;
            const email = this.dataset.email;
            const phone = this.dataset.phone;
            const address = this.dataset.full_address;
            const amount = this.dataset.amount;
            const status = this.dataset.status;
            const reference = this.dataset.refrence;
            const orderId = this.dataset.id;

            let itemsHTML = '';
            if (cartItems.length > 0) {
                itemsHTML += `<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Book / Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                cartItems.forEach(item => {
                    const total = item.price * item.quantity;
                    itemsHTML += `<tr>
                                    <td>${item.title ?? 'N/A'}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price}</td>
                                    <td>${total}</td>
                                  </tr>`;
                });
                itemsHTML += `</tbody></table>`;
            } else {
                itemsHTML = '<p>No items found.</p>';
            }

            const modalHTML = `
                <p><strong>Order ID:</strong> ${orderId}</p>
                <p><strong>User:</strong> ${userName}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Phone:</strong> ${phone}</p>
                <p><strong>Address:</strong> ${address}</p>
                <p><strong>Status:</strong> ${status}</p>
                <p><strong>Reference:</strong> ${reference}</p>
                <hr>
                <h5>Cart Items</h5>
                ${itemsHTML}
                <h4 class="text-end">Total Amount: ${amount}</h4>
            `;

            orderDetailsDiv.innerHTML = modalHTML;
            detailsModal.show();
        });
    });
});
</script>


<script>
    // excel option
    function exportToExcel(selector, filename) {
        // Table element ko select karo
        const table = document.querySelector(selector);
        if (!table) {
            alert('Table not found!');
            return;
        }
    
        // Table data ko array mein convert karo
        let data = [];
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('th, td');
            cells.forEach(cell => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });
    
        // Excel file create karne ke liye
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    
        // File download karo
        XLSX.writeFile(wb, `${filename}.xlsx`);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
$(document).ready(function () {
    $('#paymentHistoryTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        responsive: true,
        lengthMenu: [10, 25, 50, 100],
        columnDefs: [
            { orderable: false, targets: [8,9] } // disable sorting for Invoice/Delete
        ]
    });
});
</script>
@endpush
