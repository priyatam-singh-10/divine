@extends('layouts.admin')

@push('title', get_phrase('Admin Revenue'))
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
                    {{ get_phrase('Admin Revenue') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <div class="row mb-3 mt-3 row-gap-3">
                <div class="col-md-6 pt-2 pt-md-0">
                    @if ($reports->count() > 0)
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'admin-revenue')">
                                        <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'admin-revenue')">
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
                    @endif
                </div>

                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.revenue') }}" method="get">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <div class="mb-3 position-relative position-relative">
                                    <input type="text" class="form-control ol-form-control daterangepicker w-100" name="eDateRange" value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();">
                                    {{ get_phrase('Filter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('admin.transaction_tabs')

            <div class="row mt-4">
                <div class="col-md-12">
                    @if ($reports->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive enroll_history" id="enroll_history">
                            <table id="adminRevenueTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled course') }}</th>
                                        <th scope="col">{{ get_phrase('Total amount') }}</th>
                                        <th scope="col">{{ get_phrase('Admin revenue') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Option') }}</th>
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
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $item->title ?? 'N/A' }}</h4>
                                                        <p class="mt-1 fs-12px">
                                                            {{ get_phrase('Enrolled: ') }} {{ date('d-M-Y', strtotime($report->created_at)) }}
                                                        </p>
                                                        @isset($report->coupon)
                                                            <p>{{ get_phrase('Coupon: ') }}{{ $report->coupon }}</p>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name">
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
                                                    <p>{{ date('d-M-Y', strtotime($report->created_at)) }}</p>
                                                </div>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" onclick="confirmModal('{{ route('admin.revenue.delete', $report->id) }}')">
                                                        <i class="fi-rr-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold;background:#f5f5f5">
                                        <td colspan="2" class="text-end">
                                            {{ get_phrase('Total') }} :
                                        </td>
                                        <td>
                                            {{ currency($reports->sum('amount')) }}
                                        </td>
                                        <td>
                                            {{ currency($reports->sum('admin_revenue')) }}
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
                    @if (count($reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $reports->links() }}
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
        $('#adminRevenueTable').DataTable({
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
                let totalAmount = api
                    .column(2, { page: 'current' })
                    .data()
                    .reduce((a, b) => {
                        let num = parseFloat(b.replace(/[^\d.-]/g, '')) || 0;
                        return a + num;
                    }, 0);
                let totalAdminRevenue = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce((a, b) => {
                        let num = parseFloat(b.replace(/[^\d.-]/g, '')) || 0;
                        return a + num;
                    }, 0);
                $(api.column(2).footer()).html(
                    '{{ get_phrase("Total") }}: ' + '{{ currency() }}' + totalAmount.toFixed(2)
                );
                $(api.column(3).footer()).html(
                    '{{ get_phrase("Total") }}: ' + '{{ currency() }}' + totalAdminRevenue.toFixed(2)
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

    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }
</script>
@endpush
