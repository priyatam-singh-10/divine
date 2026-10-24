@extends('layouts.admin')
@push('title', get_phrase('Purchase History'))
@push('meta')@endpush
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    @media print {
        .print-d-none { display: none !important; }
    }
</style>
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Purchase History') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <div class="row row-gap-3">
                <div class="col-md-6 pt-2 pt-md-0">
                    @if (count($reports) > 0)
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list" style="z-index: 1000;">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'purchase-history')">
                                        <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'purchase-history')">
                                        <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print()">
                                        <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            @include('admin.transaction_tabs')

            <div class="row mt-4">
                <div class="col-md-12">
                    @if (count($reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive purchase_list" id="purchase_list">
                            <table id="purchaseTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Course') }}</th>
                                        <th scope="col">{{ get_phrase('Amount') }}</th>
                                        <th scope="col">{{ get_phrase('Total Amount') }}</th>
                                        <th scope="col">{{ get_phrase('Purchased date') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Invoice') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $key => $report)
                                        @php
                                            $item = $report->course_id > 0
                                                ? App\Models\Course::where('id', $report->course_id)->firstOrNew()
                                                : null;
                                        @endphp
                                        <tr>
                                            <th scope="row"><p class="row-number">{{ $key + 1 }}</p></th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="ms-1">
                                                        <h4 class="title fs-14px">
                                                            {{ ucwords(get_user_info($report->user_id)->name ?? 'N/A') }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $item->title ?? 'N/A' }}</h4>
                                                        @isset($report->coupon)
                                                            <p>{{ get_phrase('Coupon: ') }}{{ $report->coupon }}</p>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name min-w-200px">
                                                    <p>{{ currency($report->amount) }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ currency($report->admin_revenue) }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ date('d-M-Y h:i A', strtotime($report->created_at)) }}</p>
                                                </div>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <a class="btn ol-btn-light ol-icon-btn"
                                                       data-bs-toggle="tooltip"
                                                       title="{{ get_phrase('Print') }}"
                                                       href="{{ route('admin.purchase.history.invoice', $report->id) }}">
                                                        <i class="fi-rr-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold;background:#f5f5f5">
                                        <td colspan="3" class="text-end">
                                            {{ get_phrase('Total') }} :
                                        </td>
                                         <td>
                                        {{ currency(App\Models\Payment_history::sum('amount')) }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#purchaseTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, targets: [6] }
            ],
           footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                // Remove all non-numeric characters except '.' and '-'
                let total = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce((a, b) => {
                        let num = parseFloat(b.replace(/[^\d.-]/g, '')) || 0;
                        return a + num;
                    }, 0);
                $(api.column(3).footer()).html(
                    '{{ get_phrase("Total") }}: ' + total.toFixed(2)
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
@endpush
