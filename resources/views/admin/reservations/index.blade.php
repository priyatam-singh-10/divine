@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Reservations</h4>

    <!-- Filters -->
<!-- Filters -->
<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Search Name / Email / Mobile">
    </div>

    <div class="col-md-2">
        <select name="type" class="form-select">
            <option value="">All Types</option>
            <option value="session" {{ request('type') == 'session' ? 'selected' : '' }}>Session</option>
            <option value="course" {{ request('type') == 'course' ? 'selected' : '' }}>Course</option>
        </select>
    </div>

    <div class="col-md-2">
        <select name="payment_status" class="form-select">
            <option value="">All Payment Status</option>
            <option value="PENDING" {{ request('payment_status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
            <option value="SUCCESS" {{ request('payment_status') == 'SUCCESS' ? 'selected' : '' }}>Success</option>
            <option value="FAILED" {{ request('payment_status') == 'FAILED' ? 'selected' : '' }}>Failed</option>
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            Filter
        </button>
    </div>

    <div class="col-md-2">
        <a href="{{ route('admin.reservations') }}" 
           class="btn btn-outline-secondary w-100">
            Clear
        </a>
    </div>

</form>




    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table id="reservationTable" class="table eTable eTable-2 print-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Mobile</th>
                         <th scope="col">Type</th>
                        <th scope="col">City</th>
                        <th scope="col">Target</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Transaction</th>
                        <th scope="col">Created</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservations as $res)
                        <tr>
                            <!--<td>{{ $res->id }}</td>-->
                            <td>{{  $loop->iteration }}</td>

                            <td>
                                <strong>{{ $res->student_name }}</strong><br>
                                <small class="text-muted">
                                    Father: {{ $res->father_name }}
                                </small>
                            </td>
                            
                             <td>{{ $res->student_email }}</td>

                            <td>{{ $res->mobile_no }}</td>
                            
                             <td>{{ $res->type }}</td>

                            <td>{{ $res->city }}</td>

                            <td>{{ $res->target_exam }}</td>

                            <td>
                                @if($res->payment_status === 'SUCCESS')
                                    <span class="badge bg-success">Success</span>
                                @elseif($res->payment_status === 'FAILED')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif

                                <div class="small text-muted">
                                    ₹{{ number_format($res->payment_amount, 2) }}
                                </div>
                            </td>

                            <td class="small">
                                {{ $res->payment_order_id ?? '-' }}
                            </td>

                            <td class="small">
                                {{ $res->payment_transaction_id ?? '-' }}
                            </td>

                            <td class="small text-muted">
                                {{ $res->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No reservations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <script>
            $(document).ready(function () {
                $('#reservationTable').DataTable({
                    pageLength: 10,
                    ordering: true,
                    searching: true,
                    responsive: true
                });
            });
            </script>

        </div>
    </div>

 

</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection
