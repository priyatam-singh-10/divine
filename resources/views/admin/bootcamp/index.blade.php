@extends('layouts.admin')
@push('title', get_phrase('Webinars Manager'))

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
        <div class="ol-card-body py-12px px-20px my-3">
            <div class="d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage Webinars') }}
                </h4>
                <a href="{{ route('admin.webinar.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add New Webinar') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body mb-5 p-3">
                    <div class="row mb-4 mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="custom-dropdown ms-2">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'webinars-list')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="exportToExcel('.print-table', 'webinars-list')">
                                            <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="window.print();">
                                            <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="custom-dropdown dropdown-filter @if (!isset($_GET) || (isset($_GET) && count($_GET) == 0))  @endif">
                                <button class="dropdown-header btn ol-btn-light">
                                    <i class="fi-rr-filter me-2"></i>
                                    {{ get_phrase('Filter') }}
                                    <span class="text-12px"> (2)</span>
                                </button>
                                <ul class="dropdown-list w-250px">
                                    <li>
                                        <form id="filter-dropdown" action="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}" method="get">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <div class="filter-option d-flex flex-column gap-3">
                                                <div class="d-none">
                                                    <label for="eDataList" class="form-label ol-form-label">{{ get_phrase('Category') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="category" data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}</option>
                                                        @foreach (App\Models\BootcampCategory::orderBy('title', 'asc')->get() as $category)
                                                            <option value="{{ $category->slug }}" @if (request('category') == $category->slug) selected @endif>
                                                                {{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="eDataList" class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status" class="ol-select-2" data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}</option>
                                                        <option value="active"@if (request('status') == 'active') selected @endif>
                                                            {{ get_phrase('Active') }}
                                                        </option>
                                                        <option value="inactive"@if (request('status') == 'inactive') selected @endif>
                                                            {{ get_phrase('Inactive') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <!--<div>-->
                                                <!--    <label for="eDataList" class="form-label ol-form-label">{{ get_phrase('Instructor') }}</label>-->
                                                <!--    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="instructor" class="ol-select-2" data-placeholder="Type to search...">-->
                                                <!--        <option value="all">{{ get_phrase('All') }}</option>-->
                                                <!--        @foreach (App\Models\Course::select('user_id')->distinct()->get() as $course)-->
                                                <!--            <option value="{{ $course->user_id }}"@if (request('instructor') == $course->user_id) selected @endif>-->
                                                <!--                {{ ucfirst(get_user_info($course->user_id)->name) }}-->
                                                <!--            </option>-->
                                                <!--        @endforeach-->
                                                <!--    </select>-->
                                                <!--</div>-->
                                                <div>
                                                    <label for="eDataList" class="form-label ol-form-label">{{ get_phrase('Price') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="price" class="ol-select-2" data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}</option>
                                                        <option value="free"@if (request('price') == 'free') selected @endif>
                                                            {{ get_phrase('Free') }}
                                                        </option>
                                                        <option value="discounted"@if (request('price') == 'discounted') selected @endif>
                                                            {{ get_phrase('Discounted') }}
                                                        </option>
                                                        <option value="paid"@if (request('price') == 'paid') selected @endif>
                                                            {{ get_phrase('Paid') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filter-button d-flex justify-content-end align-items-center mt-3">
                                                <button type="submit" class="ol-btn-primary">{{ get_phrase('Apply') }}</button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            @if (isset($_GET) && count($_GET) > 0)
                                <a href="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}" class="me-2" data-bs-toggle="tooltip" title="{{ get_phrase('Clear') }}">
                                    <i class="fi-rr-cross-circle"></i>
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 mt-md-0 mt-3">
                            <form action="{{ route('admin.webinars', ['type' => request()->route()->parameter('type')]) }}" method="get">
                                @php
                                    $queries = request()->query();
                                    unset($queries['search']);
                                @endphp
                                <div class="row">
                                    <div class="col-9">
                                        <div class="search-input flex-grow-1">
                                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Title') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                                @foreach ($queries as $key => $query)
                                    <input type="hidden" name="{{ $key }}" value="{{ $query }}">
                                @endforeach
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($bootcamps->count() > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($bootcamps) . ' ' . get_phrase('of') . ' ' . $bootcamps->total() . ' ' . get_phrase('data') }}
                                    </p>
                                </div>
                                <div class="table-responsive course_list overflow-auto" id="course_list">
                                    <table id="webinarsTable" class="table eTable eTable-2 print-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ get_phrase('Title') }}</th>
                                                <th scope="col">{{ get_phrase('Enrolled Student') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Status') }}</th>
                                                <th scope="col">{{ get_phrase('Price') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bootcamps as $key => $bootcamp)
                                                <tr>
                                                    <th scope="row">
                                                        <p class="row-number">{{ ++$key }}</p>
                                                    </th>
                                                    <td>
                                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                            <div class="dAdmin_profile_name">
                                                                <h4 class="title fs-14px">
                                                                    <a href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'curriculum']) }}">{{ ucfirst($bootcamp->title) }}</a>
                                                                </h4>
                                                                <a href="{{ route('admin.webinars', ['instructor' => $bootcamp->user_id]) }}">
                                                                    <p class="sub-title2 text-12px">
                                                                        {{ get_phrase('Instructor') }}: {{ get_user_info($bootcamp->user_id)->name }}
                                                                    </p>
                                                                    <p class="sub-title2 text-12px">
                                                                        {{ get_phrase('Email') }}: {{ get_user_info($bootcamp->user_id)->email }}
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="sub-title2 text-12px">
                                                            <p>{{ get_phrase('Enrollments') }}: {{ bootcamp_enrolls($bootcamp->id) }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="print-d-none">
                                                        <span class="badge bg-{{ $bootcamp->status ? 'success' : 'danger' }}">
                                                            {{ get_phrase($bootcamp->status ? 'Active' : 'Inactive') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-150px">
                                                            @if ($bootcamp->is_paid == 0)
                                                                <p class="eBadge ebg-soft-success">{{ get_phrase('Free') }}</p>
                                                            @else
                                                                <p>{{ currency($bootcamp->price - $bootcamp->discounted_price) }}</p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="print-d-none">
                                                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="fi-rr-menu-dots-vertical"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" target="_blank" href="{{ route('webinar.details', $bootcamp->slug) }}">
                                                                        <i class="fi-rr-eye me-2"></i>{{ get_phrase('Frontend View') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('admin.webinar.edit', [$bootcamp->id, 'tab' => 'basic']) }}">
                                                                        <i class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                                    </a>
                                                                </li>
                                                                @if ($bootcamp->status)
                                                                    <li>
                                                                        <a class="dropdown-item" onclick="confirmModal('{{ route('admin.webinar.status', ['id' => $bootcamp->id]) }}')" href="javascript:void(0)">
                                                                            <i class="fi-rr-ban me-2"></i>{{ get_phrase('Make As Inactive') }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item" onclick="confirmModal('{{ route('admin.webinar.status', ['id' => $bootcamp->id]) }}')" href="javascript:void(0)">
                                                                            <i class="fi-rr-check me-2"></i>{{ get_phrase('Make As Active') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <a class="dropdown-item" onclick="confirmModal('{{ route('admin.webinar.duplicate', $bootcamp->id) }}')" href="javascript:void(0)">
                                                                        <i class="fi-rr-copy me-2"></i>{{ get_phrase('Duplicate') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" onclick="confirmModal('{{ route('admin.webinar.delete', $bootcamp->id) }}')" href="javascript:void(0)">
                                                                        <i class="fi-rr-trash me-2"></i>{{ get_phrase('Delete') }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($bootcamps) . ' ' . get_phrase('of') . ' ' . $bootcamps->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $bootcamps->links() }}
                                </div>
                            @else
                                @include('admin.no_data')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection

@push('js')
<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#webinarsTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, targets: [5] }
            ]
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
