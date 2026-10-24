@extends('layouts.admin')
@push('title', get_phrase('Leads Purchase History'))
@push('meta')@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
    <!-- Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row mb-3 print-d-none align-items-center">

                        <!-- Export Left -->
                        <div class="col-md-3">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="downloadPDF('.print-table', 'lead-purchase')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('.print-table', 'plans')">
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

                        <!-- Filters Right -->
                        <div class="col-md-9">
                            <form method="GET" class="">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="date" name="from_date" class="form-control ol-form-control"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="to_date" class="form-control ol-form-control"
                                            value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-4 d-flex gap-3">
                                        <button type="submit" class="btn ol-btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>

                                        <a href="{{ route('admin.leads.purchase') }}"
                                            class="px-2 dropdown-header btn ol-btn-light">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Table -->
                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table" id="plansTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('Webinar') }}</th>
                                    <th>{{ get_phrase('Customer Name') }}</th>
                                    <th>{{ get_phrase('Mobile') }}</th>
                                    <th>{{ get_phrase('Price') }}</th>
                                    <th>{{ get_phrase('Payment Method') }}</th>
                                    <th>{{ get_phrase('Payment Status') }}</th>
                                    <th>{{ get_phrase('Created Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $key => $lead)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>
                                            <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="title fs-14px">{{ $lead->webinar_name ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="title fs-14px">{{ $lead->user_name ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="title fs-14px">{{ $lead->mobile ?? 'N/A' }}</h4>

                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <h4 class="title fs-14px">₹ {{ $lead->price ?? 'N/A' }}</h4>
                                        </td>
                                        <td>
                                            {{ $lead->payment_gateway ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($lead->payment_status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($lead->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($lead->payment_status == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('d M Y h:i A', strtotime($lead->created_at)) }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="copyMessage"
                            style="position: fixed; top: 20px; left: 60%; transform: translateX(-50%);
                                    background:#028f94; color:#fff; padding:10px 20px; border-radius:6px;
                                    display:none; z-index:9999; font-weight:500;">
                            Link copied successfully
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!--<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>-->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#plansTable').DataTable({
                dom: '<"d-flex justify-content-between mb-2"i f>rtp', // info left, search right
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: false
            });
        });


        // Export to Excel
        function exportToExcel(selector, filename) {
            const table = document.querySelector(selector);
            if (!table) {
                alert('Table not found!');
                return;
            }
            let data = [];
            table.querySelectorAll('tr').forEach(row => {
                let rowData = [];
                row.querySelectorAll('th, td').forEach(cell => rowData.push(cell.innerText));
                data.push(rowData);
            });
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, `${filename}.xlsx`);
        }
    </script>
@endpush
