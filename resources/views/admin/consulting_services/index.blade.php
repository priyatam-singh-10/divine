@extends('layouts.admin')

@push('title', get_phrase('Consulting Service Requests'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <!-- Header -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-user me-2"></i>
                    <span>{{ get_phrase('Consulting Service Requests') }}</span>
                </h4>
               
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
                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'consulting-services')">
                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="window.print();">
                            <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'consulting-services')">
                            <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Search -->
        <div class="col-md-6">
            <form action="{{ route('admin.consultation-services') }}" method="get">
                <div class="row row-gap-3">
                    <div class="col-md-9">
                        <div class="search-input">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="{{ get_phrase('Search Requests') }}" class="ol-form-control form-control" />
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
                    @if($services->count() > 0)
                        <div class="table-responsive">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Name') }}</th>
                                        <th>{{ get_phrase('Email') }}</th>
                                        <th>{{ get_phrase('Phone') }}</th>
                                        <th>{{ get_phrase('Service') }}</th>
                                      
                                        <th>{{ get_phrase('Date') }}</th>
                                        <th>{{ get_phrase('Time Slots') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                        <th>{{ get_phrase('View') }}</th>
                                        <th class="print-d-none">{{ get_phrase('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ ucwords($service->name) }}</td>
                                            <td>{{ $service->email }}</td>
                                            <td>{{ $service->phone }}</td>
                                            <td>{{ $service->service }}</td>
                                           
                                          <!-- Date = when user created booking -->
                                           <td>{{ $service->created_at->format('Y-m-d H:i') }}</td>
                                             <!-- Time Slot = admin-defined slot date + time -->
                                           <td>{{ $service->time_slot }}</td>
                                            <td>
                                                <span class="badge bg-{{ $service->status_badge_class }}">
                                                    {{ ucfirst($service->status ?? 'pending') }}
                                                </span>
                                            </td>

                                            <td class="print-d-none">
                                                <button class="btn btn-sm btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewServiceModal"
                                                    data-slotid="{{ $service->slot_id }}"
                                                    data-name="{{ $service->name }}"
                                                    data-email="{{ $service->email }}"
                                                    data-phone="{{ $service->phone }}"
                                                    data-service="{{ $service->service }}"
                                                    data-page="{{ $service->page }}"
                                                    data-date="{{ $service->created_at->format('Y-m-d H:i') }}"
                                                    data-slot="{{ $service->time_slot }}"
                                                    data-status="{{ ucfirst($service->status ?? 'pending') }}"
                                                    data-details="{{ $service->additional_details }}"
                                                >
                                                    {{ get_phrase('View') }}
                                                </button>
                                            </td>
                                                                                    <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <!-- Reschedule -->
                                                        <li>
                                                            <!-- Reschedule -->
                                                            <li>
                                                                <a href="javascript:void(0);" 
                                                                   class="dropdown-item" 
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#rescheduleModal"
                                                                   data-id="{{ $service->id }}"
                                                                   data-date="{{ $service->date }}"
                                                                   data-start-time="{{ $service->start_time }}"
                                                                   data-end-time="{{ $service->end_time }}"
                                                                   >
                                                                <i class="fi-rr-refresh me-2"></i> {{ get_phrase('Reschedule') }}
                                                                </a>
                                                            </li>

                                                        </li>
                                                        <!-- Delete -->
                                                        <li>
                                                            <a class="dropdown-item" onclick="confirmModal('{{ route('admin.consulting-services.delete', $service->id) }}')" href="javascript:void(0)">
                                                                <i class="fi-rr-trash me-2"></i>  {{ get_phrase('Delete') }}
                                                            </a>
                                                        </li>
                                                        
                                                        <li>
                                                            <form id="confirmForm-{{ $service->id }}" action="{{ route('admin.consulting-services.update-status', $service->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('confirmForm-{{ $service->id }}').submit();">
                                                                    <i class="fi-rr-check me-2"></i> {{ get_phrase('Confirm') }}
                                                                </a>
                                                            </form>
                                                        </li>
                                                    
                                                        <!-- Cancel -->
                                                        <li>
                                                            <form id="cancelForm-{{ $service->id }}" action="{{ route('admin.consulting-services.update-status', $service->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('cancelForm-{{ $service->id }}').submit();">
                                                                    <i class="fi-rr-ban me-2"></i> {{ get_phrase('Cancel') }}
                                                                </a>
                                                            </form>
                                                        </li>
                                                        
                                                        
                                                        <!-- Change Status -->
                                                        <!--<li>-->
                                                        <!--    <form action="{{ route('admin.consulting-services.update-status', $service->id) }}" method="POST" class="px-3">-->
                                                        <!--        @csrf-->
                                                        <!--        @method('PUT')-->
                                                        <!--        <select name="status" class="form-select form-select-sm mb-2">-->
                                                        <!--            <option value="">-- Select Status --</option>-->
                                                        <!--            <option value="confirmed" {{ $service->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>-->
                                                        <!--            <option value="cancelled" {{ $service->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>-->
                                                        <!--        </select>-->
                                                        <!--        <button type="submit" class="btn btn-sm btn-primary w-100">Update</button>-->
                                                        <!--    </form>-->
                                                        <!--</li>-->
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
                                {{ get_phrase('Showing') . ' ' . $services->count() . ' ' . get_phrase('of') . ' ' . $services->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $services->links() }}
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="rescheduleForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleModalLabel">{{ get_phrase('Reschedule Appointment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ get_phrase('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="reschedule_id">
                    <div class="mb-3">
                        <label for="reschedule_date" class="form-label">{{ get_phrase('Date') }}</label>
                        <input type="date" name="date" id="reschedule_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reschedule_start_time" class="form-label">{{ get_phrase('Start Time') }}</label>
                        <input type="time" name="start_time" id="reschedule_start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reschedule_end_time" class="form-label">{{ get_phrase('End Time') }}</label>
                        <input type="time" name="end_time" id="reschedule_end_time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ get_phrase('Update') }}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- View Details Modal -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ get_phrase('Service Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ get_phrase('Close') }}"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                     <tr>
                        <th>{{ get_phrase('SlotID') }}</th>
                        <td id="view_slot_id"></td>
                    </tr>
                    
                    <tr>
                        <th>{{ get_phrase('Name') }}</th>
                        <td id="view_name"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Email') }}</th>
                        <td id="view_email"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Phone') }}</th>
                        <td id="view_phone"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Service') }}</th>
                        <td id="view_service"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Page') }}</th>
                        <td id="view_page"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Booking Date') }}</th>
                        <td id="view_date"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Time Slot') }}</th>
                        <td id="view_slot"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Status') }}</th>
                        <td id="view_status"></td>
                    </tr>
                    <tr>
                        <th>{{ get_phrase('Additional Details') }}</th>
                        <td id="view_details"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>

@push('js')

<script>
    const viewServiceModal = document.getElementById('viewServiceModal');

        viewServiceModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('view_slot_id').innerText = button.getAttribute('data-slotid');
            document.getElementById('view_name').innerText = button.getAttribute('data-name');
            document.getElementById('view_email').innerText = button.getAttribute('data-email');
            document.getElementById('view_phone').innerText = button.getAttribute('data-phone');
            document.getElementById('view_service').innerText = button.getAttribute('data-service');
            document.getElementById('view_page').innerText = button.getAttribute('data-page');
            document.getElementById('view_date').innerText = button.getAttribute('data-date');
            document.getElementById('view_slot').innerText = button.getAttribute('data-slot');
            document.getElementById('view_status').innerText = button.getAttribute('data-status');
            document.getElementById('view_details').innerText = button.getAttribute('data-details');
        });

      const rescheduleModal = document.getElementById('rescheduleModal');

    rescheduleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const serviceId = button.getAttribute('data-id');
        const date = button.getAttribute('data-date');
        const startTime = button.getAttribute('data-start-time');
        const endTime = button.getAttribute('data-end-time');

        document.getElementById('reschedule_id').value = serviceId;
        document.getElementById('reschedule_date').value = date;
        document.getElementById('reschedule_start_time').value = startTime;
        document.getElementById('reschedule_end_time').value = endTime;

        document.getElementById('rescheduleForm').action = `/admin/consulting-services/${serviceId}/reschedule`;
    });

    function exportToExcel(selector, filename) {
        const table = document.querySelector(selector);
        if (!table) return alert('Table not found!');

        let data = [];
        table.querySelectorAll('tr').forEach(row => {
            let rowData = [];
            row.querySelectorAll('th, td').forEach(cell => {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endpush

@push('js')@endpush
