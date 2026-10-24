@extends('layouts.admin')
@push('title', get_phrase('Enquiries'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <!-- Header with title -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Enquiries') }}</span>
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
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'enquiries')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();">
                                            <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'enquiries-list')">
                                            <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="col-md-6">
                            <form action="{{ route('admin.enquiries') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Enquiries') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn ol-btn-primary px-2 w-100" id="submit-button">
                                            {{ get_phrase('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    @if($enquiries->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . $enquiries->count() . ' ' . get_phrase('of') . ' ' . $enquiries->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>

                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Name') }}</th>
                                        <th scope="col">{{ get_phrase('Contact Info') }}</th>
                                        <th scope="col">{{ get_phrase('Subject') }}</th>
                                        <th scope="col">{{ get_phrase('Message') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquiries as $key => $enquiry)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{  ucwords($enquiry->name)  }}</h4>
                                                        <p class="sub-title2 text-12px">
                                                            {{ $enquiry->created_at->format('d M, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="sub-title2 text-12px">{{ get_phrase('Email') }}: {{ $enquiry->email }}</p>
                                                <p class="sub-title2 text-12px">{{ get_phrase('Phone') }}: {{ $enquiry->phone ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="sub-title2 text-12px">{{ ucfirst($enquiry->subject ?? 'N/A') }}</p>
                                            </td>
                                            <td>
                                                <p class="sub-title text-12px">{{ Str::limit($enquiry->message, 50) }}</p>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                             <a class="dropdown-item"
                                                               onclick="ajaxModal('{{ route('modal', ['admin.enquiries.reply', 'enquiry_id' => $enquiry->id]) }}', '{{ get_phrase('Reply to Enquiry') }}')">
                                                                <i class="fi-rr-comment me-2"></i>{{ get_phrase('Reply') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                               onclick="confirmModal('{{ route('admin.enquiry.delete', $enquiry->id) }}')"
                                                               href="javascript:void(0)">
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
                    @else
                        @include('admin.no_data')
                    @endif

                    <!-- Pagination -->
                    @if ($enquiries->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . $enquiries->count() . ' ' . get_phrase('of') . ' ' . $enquiries->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $enquiries->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
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
@endpush
