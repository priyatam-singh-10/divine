@extends('layouts.admin')
@push('title', get_phrase('Blog'))

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    @media print {
        .print-d-none { display: none !important; }
    }
</style>
@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Blog') }}
                </h4>

                <a href="{{ route('admin.blog.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new blog') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'blog-list')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'blog-list')">
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
                        <div class="col-md-6">
                            <form action="{{ route('admin.blogs') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Title') }}" class="ol-form-control form-control" />
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
                    @if (count($blogs) > 0)
                        <div class="table-responsive course_list" id="course_list">
                            <table id="blogsTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Creator') }}</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col">{{ get_phrase('Category') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Status') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="40" height="40" src="{{ get_image($blog->user->photo) }}" />
                                                    </div>
                                                    <div class="ms-1 mt-1">
                                                        <h4 class="title fs-14px">{{ $blog->user->name }}</h4>
                                                        <p class="sub-title2 text-12px">{{ $blog->user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p><a href="{{ route('blog.details', ['slug' => slugify($blog->title)]) }}">{{ $blog->title }}</a></p>
                                                    <small class="sub-title2 text-11px">{{ date('D, d-M-Y', strtotime($blog->created_at)) }}</small>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $category = DB::table('blog_categories')
                                                        ->where('id', $blog->category_id)
                                                        ->first();
                                                @endphp
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>{{ $category->title ?? 'N/A' }}</p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <div class="eSwitches">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input form-switch-medium" onchange="actionTo('{{ route('admin.blog.status', ['id' => $blog->id]) }}');" type="checkbox" @if ($blog->status) checked @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.blog.edit', ['id' => $blog->id]) }}">
                                                                <i class="fi-rr-edit me-2"></i>{{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.blog.delete', $blog->id) }}')">
                                                                <i class="fi-rr-trash me-2"></i>{{ get_phrase('Delete') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('blog.details', slugify($blog->title)) }}">
                                                                <i class="fi-rr-eye me-2"></i>{{ get_phrase('View on frontend') }}
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
                   
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection

@push('js')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#blogsTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            responsive: true,
            lengthMenu: [10, 25, 50, 100],
            columnDefs: [
                { orderable: false, targets: [4, 5] }
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

    function actionTo(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    location.reload();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endpush
