@extends('layouts.admin')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ol-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Link Enroll Purchase History</h4>
                
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#purchaseLinkModal">
                        <i class="fa fa-link"></i> Update Purchase Link
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="purchaseHistoryTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Course</th>
                                <th>Price</th>
                                <th>Payment ID</th>
                                <th>Purchase Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $key => $purchase)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $purchase->first_name }} {{ $purchase->last_name }}</td>
                                <td>{{ $purchase->email }}</td>
                                <td>{{ $purchase->mobile }}</td>
                                <td>{{ $purchase->city }}</td>
                                <td>{{ $purchase->course_name }}</td>
                                <td>₹{{ $purchase->price }}</td>
                                <td>{{ $purchase->payment_id }}</td>
                                <td>{{ date('d M Y H:i', strtotime($purchase->purchase_date)) }}</td>
                               <td>
                                    @if($purchase->status == 'Paid')
                                        <span class="badge bg-success">Paid</span>
                                
                                    @elseif($purchase->status == 'Pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                
                                    @elseif($purchase->status == 'Failed')
                                        <span class="badge bg-danger">Failed</span>
                                
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
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

<!-- Purchase Link Modal -->
<div class="modal fade" id="purchaseLinkModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Update Purchase Link</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

@php

use Illuminate\Support\Facades\DB;

/* Get purchase link */
$link = DB::table('settings')
    ->where('type','purchase_link')
    ->value('description');

/* Extract slug from link */
$slug = null;

if($link){
    parse_str(parse_url($link, PHP_URL_QUERY), $params);
    $slug = $params['id'] ?? null;
}

/* Fetch course from mysql2 */
$activeCourse = null;

if($slug){
    $activeCourse = DB::connection('mysql2')
        ->table('courses')
        ->where('slug',$slug)
        ->first();
}

@endphp

<form action="{{ route('admin.update.purchase.link') }}" method="POST">
@csrf

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Purchase Link</label>

<input type="text"
name="purchase_link"
class="form-control"
placeholder="https://plan.divinetouch.info/buy.php?id=xxx"
value="{{ $link }}"
required>

<small class="text-muted">
Paste purchase link generated from external site.
</small>

</div>

@if($activeCourse)

<div class="alert alert-info mt-3">

<strong>Active Course:</strong><br>

<b>Name:</b> {{ $activeCourse->course_name }} <br>

<b>Price:</b> ₹{{ $activeCourse->price }} <br>

<b>Expiry Date:</b> {{ \Carbon\Carbon::parse($activeCourse->expiry_date)->format('d M Y') }}

</div>

@endif

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-success">
<i class="fa fa-save"></i> Save Link
</button>
</div>

</form>

</div>
</div>
</div>

@push('js')
<!-- jQuery -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script>
    $(document).ready(function() {
        $('#purchaseHistoryTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-sm btn-secondary'
                }
            ],
            order: [[8, 'desc']], // Default sorting by Purchase Date (column index 8)
        });
    });
</script>
@endpush
