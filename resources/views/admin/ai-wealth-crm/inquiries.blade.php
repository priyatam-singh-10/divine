@extends('layouts.admin')
@push('title', get_phrase('AI Wealth CRM Inquiry'))
@push('meta')@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .inquiry-filter-bar {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .inquiry-filter-row {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .inquiry-filter-export {
            flex: 0 0 auto;
        }
        .inquiry-import-form {
            display: flex;
            align-items: center;
            flex: 0 0 auto;
        }
        .inquiry-import-form input[type="file"] {
            display: none;
        }
        .inquiry-filter-form {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            min-width: 0;
            flex-wrap: nowrap;
        }
        .inquiry-filter-form .form-control,
        .inquiry-filter-form select {
            min-width: 0;
            height: 42px;
        }
        .inquiry-filter-search {
            flex: 1.4 1 160px;
        }
        .inquiry-filter-form select,
        .inquiry-filter-form input[type="date"] {
            flex: 1 1 130px;
        }
        .inquiry-filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            margin-left: auto;
        }
        .inquiry-filter-actions .btn,
        .inquiry-import-form .btn {
            white-space: nowrap;
            height: 42px;
            display: inline-flex;
            align-items: center;
        }
        @media (max-width: 1199px) {
            .inquiry-filter-row {
                flex-wrap: wrap;
            }
            .inquiry-filter-search,
            .inquiry-filter-form select,
            .inquiry-filter-form input[type="date"] {
                flex: 1 1 calc(33.33% - 8px);
            }
        }
        @media (max-width: 767px) {
            .inquiry-filter-search,
            .inquiry-filter-form select,
            .inquiry-filter-form input[type="date"] {
                flex: 1 1 100%;
            }
            .inquiry-filter-actions {
                width: 100%;
                margin-left: 0;
            }
            .inquiry-filter-actions .btn,
            .inquiry-import-form .btn {
                flex: 1;
                justify-content: center;
            }
        }
        .dataTables_length {
            margin: 0;
        }
        .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-weight: 500;
        }
        .dataTables_length select {
            height: 36px;
            min-width: 72px;
            border: 1px solid #d9e2ef;
            border-radius: 8px;
            padding: 0 8px;
        }
    </style>
@endpush

@section('content')
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('AI Wealth CRM') }} / {{ get_phrase('Inquiry') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <div class="inquiry-filter-bar print-d-none mb-3">
                        <div class="inquiry-filter-row">
                            <div class="custom-dropdown inquiry-filter-export">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="downloadPDF('.print-table', 'ai-wealth-inquiries')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('.print-table', 'ai-wealth-inquiries')">
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

                            <form method="POST" action="{{ route('admin.ai-wealth-crm.inquiries.import') }}" enctype="multipart/form-data" class="inquiry-import-form" id="inquiryImportForm">
                                @csrf
                                <input type="file" name="excel" id="inquiryExcelInput" accept=".xlsx,.csv" required>
                                <button type="button" class="btn ol-btn-light" id="inquiryImportBtn">
                                    {{ get_phrase('Import Excel') }}
                                    <i class="fi-rr-file-import ms-2"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.ai-wealth-crm.inquiries.whatsapp') }}" class="inquiry-import-form" onsubmit="return confirm('Send the webinar WhatsApp to all leads, including old ones?');">
                                @csrf
                                <button type="submit" class="btn ol-btn-light">
                                    {{ get_phrase('WhatsApp Send') }}
                                    <i class="fi-rr-paper-plane ms-2"></i>
                                </button>
                            </form>
                        </div>

                        <form method="GET" action="{{ route('admin.ai-wealth-crm.inquiries') }}" class="inquiry-filter-form">
                            <input type="text" name="search" class="form-control ol-form-control inquiry-filter-search"
                                placeholder="Name / Mobile / Email"
                                value="{{ request('search') }}">

                            <select name="profession" class="form-control ol-form-control">
                                <option value="">{{ get_phrase('Profession') }}</option>
                                @foreach (\App\Models\AiWealthInquiry::professionLabels() as $value => $label)
                                    <option value="{{ $value }}" @selected(request('profession') == $value)>{{ $label }}</option>
                                @endforeach
                            </select>

                            <select name="status" class="form-control ol-form-control">
                                <option value="">{{ get_phrase('Status') }}</option>
                                <option value="partial" @selected(request('status') == 'partial')">Partial</option>
                                <option value="submitted" @selected(request('status') == 'submitted')">Submitted</option>
                            </select>

                            <select name="page" class="form-control ol-form-control">
                                <option value="">{{ get_phrase('Page') }}</option>
                                @foreach (\App\Models\AiWealthInquiry::pageFilterOptions() as $value => $label)
                                    <option value="{{ $value }}" @selected(request('page') == $value)>{{ $label }}</option>
                                @endforeach
                            </select>

                            <input type="date" name="from_date" class="form-control ol-form-control"
                                value="{{ request('from_date') }}">

                            <input type="date" name="to_date" class="form-control ol-form-control"
                                value="{{ request('to_date') }}">

                            <div class="inquiry-filter-actions">
                                <button type="submit" class="btn ol-btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.ai-wealth-crm.inquiries') }}" class="btn ol-btn-light">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table" id="aiWealthInquiryTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('Name') }}</th>
                                    <th>{{ get_phrase('Mobile') }}</th>
                                    <th>{{ get_phrase('Email') }}</th>
                                    <th>{{ get_phrase('Profession') }}</th>
                                    <th>{{ get_phrase('Age Group') }}</th>
                                    <th>{{ get_phrase('Challenge') }}</th>
                                    <th>{{ get_phrase('Income') }}</th>
                                    <!--<th>{{ get_phrase('Status') }}</th>-->
                                    <th>{{ get_phrase('Page') }}</th>
                                    <th>{{ get_phrase('Created Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquiries as $key => $inquiry)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $inquiry->name ?? 'N/A' }}</td>
                                        <td>{{ $inquiry->mobile ?? 'N/A' }}</td>
                                        <td>{{ $inquiry->email ?: 'N/A' }}</td>
                                        <td>{{ $inquiry->profession_label }}</td>
                                        <td>{{ $inquiry->age_group ?: 'N/A' }}</td>
                                        <td>{{ $inquiry->challenge_label }}</td>
                                        <td>{{ $inquiry->income_label }}</td>
                                        <!--<td>-->
                                        <!--    @if ($inquiry->status === 'submitted')-->
                                        <!--        <span class="badge bg-success">Submitted</span>-->
                                        <!--    @else-->
                                        <!--        <span class="badge bg-warning text-dark">Partial</span>-->
                                        <!--    @endif-->
                                        <!--</td>-->
                                        <td>{{ $inquiry->page_label }}</td>
                                        <td>{{ date('d M Y h:i A', strtotime($inquiry->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#aiWealthInquiryTable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2"lf>rt<"d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2"ip>',
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                pageLength: 10,
                lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, 'All']],
                order: [[10, 'desc']],
                columnDefs: [
                    { orderable: false, searchable: false, targets: 0 }
                ],
                drawCallback: function () {
                    var api = this.api();
                    var start = api.page.info().start;
                    api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                        cell.innerHTML = start + i + 1;
                    });
                }
            });

            var importBtn = document.getElementById('inquiryImportBtn');
            var excelInput = document.getElementById('inquiryExcelInput');
            var importForm = document.getElementById('inquiryImportForm');
            if (importBtn && excelInput && importForm) {
                importBtn.addEventListener('click', function () {
                    excelInput.click();
                });
                excelInput.addEventListener('change', function () {
                    if (!this.files.length) return;
                    if (confirm('Import leads and send welcome WhatsApp to new numbers?')) {
                        importForm.submit();
                    } else {
                        this.value = '';
                    }
                });
            }
        });

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
