@extends('layouts.admin')
@push('title', get_phrase('Purchase History'))

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
        <div class="ol-card-body my-3 py-4 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Purchase History') }}
                </h4>
            </div>
        </div>
    </div>

    @include('admin.transaction_tabs')

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'bootcamp-payment-history')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'bootcamp-payment-history')">
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
                    </div>

                    <!-- Table -->
                    @if (count($purchases) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($purchases) . ' ' . get_phrase('of') . ' ' . $purchases->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table id="purchaseHistoryTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Live Class') }}</th>
                                        <th scope="col">{{ get_phrase('Price') }}</th>
                                        <th scope="col">{{ get_phrase('Date') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $key => $report)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="40" height="40" src="{{ get_image(get_user_info($report->user_id)->photo) }}">
                                                    </div>
                                                    <div class="ms-1 mt-1">
                                                        <h4 class="title fs-14px">{{ get_user_info($report->user_id)->name }}</h4>
                                                        <p class="sub-title2 text-12px">{{ get_user_info($report->user_id)->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="sub-title2 text-12px min-w-150px">
                                                    <a href="{{ route('webinar.details', $report->slug) }}">{{ $report->title }}</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="sub-title2 text-12px min-w-150px">
                                                    <p>{{ currency(number_format($report->price, 2)) }}</p>
                                                    <p><span>{{ get_phrase('Admin :') }} </span>{{ currency(number_format($report->admin_revenue, 2)) }}</p>
                                                    <p><span>{{ get_phrase('Author :') }} </span>{{ currency(number_format($report->instructor_revenue, 2)) }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="sub-title2 text-12px">
                                                    <p>{{ date('d-M-y h:i A', strtotime($report->created_at)) }}</p>
                                                </div>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="sub-title2 text-12px text-capitalize">
                                                    <a href="{{ route('admin.webinar.purchase.invoice', $report->id) }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                                        <span>{{ get_phrase('Invoice') }}</span>
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
                                            {{ currency(number_format($purchases->sum('price'), 2)) }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif

                    <!-- Data info and Pagination -->
                    @if (count($purchases) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($purchases) . ' ' . get_phrase('of') . ' ' . $purchases->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $purchases->links() }}
                        </div>
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
        $('#purchaseHistoryTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, targets: [5] }
            ],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                let totalPrice = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce((a, b) => {
                        let num = parseFloat(b.replace(/[^\d.-]/g, '')) || 0;
                        return a + num;
                    }, 0);
                $(api.column(3).footer()).html(
                    '{{ get_phrase("Total") }}: ' + '{{ currency() }}' + totalPrice.toFixed(2)
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
