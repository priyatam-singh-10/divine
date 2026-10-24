@extends('layouts.admin')

@push('title', get_phrase('Consultation Slots'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-calendar me-2"></i>
                    <span>{{ get_phrase('Consultation Slots') }}</span>
                </h4>
                <a href="consultation-services-slots-create" class="btn ol-btn-primary">
                    + {{ get_phrase('Add Slot') }}
                </a>
            </div>
        </div>
    </div>

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
                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'consultation-slots')">
                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="window.print();">
                            <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'consultation-slots')">
                            <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Search -->
        <div class="col-md-6">
            <form action="{{ route('admin.consultation-services-slots') }}" method="get">
                <div class="row row-gap-3">
                    <div class="col-md-9">
                        <div class="search-input">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="{{ get_phrase('Search Slots') }}" class="ol-form-control form-control" />
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

    <!-- Table Display -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    @if($slots->count() > 0)
                        <div class="table-responsive">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Service') }}</th>
                                        <th>{{ get_phrase('Date') }}</th>
                                        <th>{{ get_phrase('Start Time') }}</th>
                                        <th>{{ get_phrase('End Time') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                        <th class="print-d-none">{{ get_phrase('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slots as $key => $slot)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $slot->service ?? 'Astrology' }}</td> <!-- dummy service -->
                                            <td>{{ \Carbon\Carbon::parse($slot->slot_date)->format('Y-m-d') }}</td>
                                            <td>{{ $slot->start_time }}</td>
                                            <td>{{ $slot->end_time }}</td>
                                            <td>
                                                @if(is_null($slot->is_booked))
                                                    <span class="badge bg-secondary">Not Set</span>
                                                @elseif($slot->is_booked)
                                                    <span class="badge bg-danger">Booked</span>
                                                @else
                                                    <span class="badge bg-success">Available</span>
                                                @endif
                                            </td>
                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <!-- Edit -->
                                                        <li>
                                                            <a href="{{ route('admin.consultation-services-slots-edit', $slot->id) }}" class="dropdown-item">
                                                                <i class="fi-rr-edit me-2"></i> {{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>
                                                        <!-- Delete -->
                                                        <li>
                                                            <a class="dropdown-item" onclick="confirmModal('{{ route('admin.consultation-services-slots-delete', $slot->id) }}')" href="javascript:void(0)">
                                                                <i class="fi-rr-trash me-2"></i> {{ get_phrase('Delete') }}
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

                        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15 mt-3">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . $slots->count() . ' ' . get_phrase('of') . ' ' . $slots->total() . ' ' . get_phrase('slots') }}
                            </p>
                            {{ $slots->links() }}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    // excel option
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
            cells.forEach(cell => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, `${filename}.xlsx`);
    }
</script>
@endpush
