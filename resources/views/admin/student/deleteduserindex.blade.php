@extends('layouts.admin')
@push('title', get_phrase('Student'))
@push('meta')
@endpush
@push('css')
@endpush
@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('User List') }}
            </h4>

            <a href="{{ route('admin.student.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add new User') }}</span>
            </a>
        </div>
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
                            <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'student-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                        </li>
                         <li>
                            <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'student-list')">
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
                <form class="form-inline" action="{{ route('admin.student.deleteduserindex') }}" method="get">
                    <div class="row row-gap-3">
                        <div class="col-md-9">
                            <input type="text" class="form-control ol-form-control" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search user') }}" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn ol-btn-primary w-100" id="submit-button"> {{ get_phrase('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
             <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                    <form action="{{ route('admin.student.deleteduserindex') }}" method="GET" class="d-flex flex-wrap align-items-end gap-2">

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
                            <a href="{{ route('admin.student.deleteduserindex') }}" class="btn btn-secondary mt-3">{{ get_phrase('Reset') }}</a>
                        </div>

                    </form>
                </div>
            <div class="col-md-12">
                @if (count($students) > 0)
                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                    <p class="admin-tInfo">
                        {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                    </p>
                </div>
                
                <div class="table-responsive course_list" id="course_list">
                     <div id="student-search-results">
                    <table class="table eTable eTable-2 print-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ get_phrase('Name') }}</th>
                                <th scope="col">{{ get_phrase('Email') }}</th> <!-- New column for email -->
                                <th scope="col">{{ get_phrase('Phone') }}</th>
                                <th scope="col">{{ get_phrase('Address') }}</th>
                                <th scope="col">{{ get_phrase('Enrolled Course') }}</th>
                                <th scope="col">{{ get_phrase('Registered At') }}</th>
                                <!--<th scope="col">{{ get_phrase('Status') }}</th>-->
                                <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody id="student-table-body">
                            @foreach ($students as $key => $row)
                            
                            
                            @php
                          $addr = $row->full_address ?? [];
                                $country = isset($addr['country']) ? \DB::table('countries')->where('id', $addr['country'])->value('name') : '';
                                $state   = isset($addr['state']) ? \DB::table('states')->where('id', $addr['state'])->value('name') : '';
                                $city    = isset($addr['city']) ? \DB::table('cities')->where('id', $addr['city'])->value('name') : '';
                                $street  = $addr['address'] ?? '';
                                $zip     = $addr['zipcode'] ?? '';
                                $fullAddress = trim("{$street}, {$city}, {$state}, {$country}, {$zip}", ', ');
                          @endphp
  <tr>
            <th scope="row">
                <p class="row-number">{{ ++$key }}</p>
            </th>
            <td>
                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                    <div class="dAdmin_profile_img">
                        <img class="img-fluid rounded-circle image-45" width="45" height="45"
                            src="{{ $row->photo && file_exists(public_path($row->photo)) 
                                ? asset($row->photo) 
                                : asset('uploads/users/student/placeholder/placeholder.PNG') }}" />
                    </div>
                    <div class="ms-1">
                        <h4 class="title fs-14px">{{ ucwords($row->name) }}</h4>
                    </div>
                </div>
            </td>
            <td>
                <div class="dAdmin_info_name min-w-200px">
                    <p>{{ $row->email }}</p>
                </div>
            </td>
            <td>
                <div class="dAdmin_info_name min-w-150px">
                    <p>{{ $row->phone }}</p>
                </div>
            </td>
             <td>
                 
                <div class="dAdmin_info_name min-w-150px">
                    <p>{{ Str::limit($fullAddress, 30, '..') }}</p>
                </div>
            </td>
            <td>
                {{ App\Models\Enrollment::where('user_id', $row->id)->count() }}
                {{ get_phrase('Courses') }}
            </td>
            <td>
                <div class="dAdmin_info_name min-w-150px">
                    <p>{{ $row->created_at ? $row->created_at->format('d M Y, h:i A') : '-' }}</p>
                </div>
            </td>
            <!--<td>-->
                <!--<div class="form-check form-switch">-->
                <!--    <input -->
                <!--        class="form-check-input changeStatus" -->
                <!--        type="checkbox" -->
                <!--        data-id="{{ $row->id }}" -->
                <!--        {{  $row->status == 1 ? 'checked' : '' }}-->
                <!--    >-->
                <!--</div>-->
            <!--</td>-->
            <td class="print-d-none">
                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @if(($row->deleted_at))
                           
                            {{-- Restore --}}
                            <li>
                                <a class="dropdown-item text-success" 
                                   href="{{ route('admin.student.restore', $row->id) }}">
                                    <i class="fi-rr-refresh me-2"></i> {{ get_phrase('Restore') }}
                                </a>
                            </li>
                    
                            {{-- Permanent Delete --}}
                            <li>
                                <a class="dropdown-item text-danger" 
                                   onclick="confirmModal('{{ route('admin.student.forcedelete', $row->id) }}')" 
                                   href="javascript:void(0)">
                                    <i class="fi-rr-cross-circle me-2"></i> {{ get_phrase('Delete Permanently') }}
                                </a>
                            </li>
                        @endif
                    </ul>

                </div>
            </td>
        </tr>
                            
                            
                            <!-- Modal -->
                            <div class="modal fade" id="studentModal{{ $row->id }}" tabindex="-1" aria-labelledby="studentModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="studentModalLabel{{ $row->id }}">{{ ucwords($row->name) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($row->photo)
                <div class="text-center mb-3">
                    <img class="rounded-circle" src="{{ asset($row->photo) }}" width="100" height="100" style="object-fit: cover;">
                </div>
                @endif

                <div class="mb-3">
                    <strong class="text-muted">{{ get_phrase('Email') }}</strong>
                    <p class="mb-0 fw-medium">{{ $row->email }}</p>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">{{ get_phrase('Phone') }}</strong>
                    <p class="mb-0 fw-medium">{{ $row->phone }}</p>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">{{ get_phrase('Address') }}</strong>
                    <p class="mb-0 fw-medium">{{ $row->address }}</p>
                </div>

            
                
                    <div class="mb-3">
                        <strong class="text-muted">{{ get_phrase('Full Address') }}</strong>
                        <p class="mb-0 fw-medium">{{   $fullAddress }}</p>
                    </div>
               

                <div class="mb-3">
                    <strong class="text-muted">{{ get_phrase('Enrolled Courses') }}</strong>
                    <p class="mb-0 fw-medium">{{ App\Models\Enrollment::where('user_id', $row->id)->count() }}</p>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">{{ get_phrase('Registered At') }}</strong>
                    <p class="mb-0 fw-medium">{{ $row->created_at ? $row->created_at->format('d M Y, h:i A') : '-' }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>

                @else
                @include('admin.no_data')
                @endif

                @if (count($students) > 0)
                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                    <p class="admin-tInfo">
                        {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                    </p>
                    {{ $students->links() }}
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).on('change', '.changeStatus', function() {
    let id = $(this).data('id');
    let _token = "{{ csrf_token() }}";

    $.ajax({
        url: "{{ url('/admin/student/status') }}/" + id,
        type: "POST",
        data: { _token: _token },
        success: function(response) {
            
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to update status!');
            }
        },
        error: function() {
            toastr.error('Something went wrong!');
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[name="search"]');
    const tableBody   = document.getElementById('student-table-body');

    let timeout = null;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);
        const query = this.value;

        timeout = setTimeout(() => {
            // Preserve any existing filters (start_date, end_date)
            const startDate = document.querySelector('input[name="start_date"]')?.value || '';
            const endDate   = document.querySelector('input[name="end_date"]')?.value || '';

            const params = new URLSearchParams({
                search: query,
                start_date: startDate,
                end_date: endDate,
            });

            fetch(`{{ route('admin.student.deleteduserindex') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = data.html;
            })
            .catch(err => console.error(err));
        }, 300);
    });

    // prevent form submit
    const form = searchInput.closest('form');
    form.addEventListener('submit', function(e){
        e.preventDefault();
    });
});
</script>



@endpush

