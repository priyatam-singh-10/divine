@extends('layouts.admin')

@push('title', get_phrase('Books'))
@push('meta')@endpush
@push('css')@endpush

@section('content')

<!-- Header with title -->
<div class="ol-card radius-8px print-d-none">
    <div class="ol-card-body my-3 py-4 px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi fi-br-book-alt me-2"></i>
                <span>{{ get_phrase('Books') }}</span>
            </h4>
            <a href="{{ route('admin.books.create') }}" class="btn ol-btn-primary">
                <i class="fi fi-rr-plus me-1"></i> {{ get_phrase('Add Book') }}
            </a>
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
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'books')">
                                        <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportToExcel('.print-table', 'books')">
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

                    <!-- Search -->
                    <div class="col-md-6">
                        <form action="{{ route('admin.books') }}" method="get">
                            <div class="row row-gap-3">
                                <div class="col-md-9">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="{{ get_phrase('Search Books') }}"
                                           class="ol-form-control form-control" />
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn ol-btn-primary px-2 w-100">
                                        {{ get_phrase('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                @if($books->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . $books->count() . ' ' . get_phrase('of') . ' ' . $books->total() . ' ' . get_phrase('books') }}
                        </p>
                    </div>

                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ get_phrase('Cover') }}</th>
                                    <th>{{ get_phrase('Title') }}</th>
                                    <th>{{ get_phrase('Author') }}</th>
                                    <th>{{ get_phrase('Price') }}</th>
                                    <th>{{ get_phrase('Stock') }}</th>
                                    <th>{{ get_phrase('Status') }}</th>
                                    <th class="print-d-none">{{ get_phrase('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $key => $book)
                                    <tr>
                                        
                                         @php
                                            $images = json_decode($book->image, true);
                                            $coverImage = $images['cover'][0] ?? 'uploads/default-cover.png'; // fallback
                                         @endphp
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if( $coverImage)
                                               <img src="{{ asset( $coverImage) }}" alt="Cover" width="50" height="70">

                                            @else
                                                <span class="text-muted">{{ get_phrase('No Image') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>₹{{ number_format($book->price, 2) }}</td>
                                        <td>{{ $book->stock }}</td>
                                        <td>
                                            <span class="badge bg-{{ $book->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </td>
                                        <td class="print-d-none">
                                            <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <span class="fi fi-rr-menu-dots-vertical"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.books.edit', $book->id) }}">
                                                            <i class="fi fi-rr-edit me-1"></i> {{ get_phrase('Edit') }}
                                                        </a>
                                                    </li>
                                                      <li>
                                                            <a class="dropdown-item"
                                                               onclick="confirmModal('{{ route('admin.books.delete', $book->id) }}')"
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
                @if ($books->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15 mt-3">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . $books->count() . ' ' . get_phrase('of') . ' ' . $books->total() . ' ' . get_phrase('books') }}
                        </p>
                        {{ $books->links() }}
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
