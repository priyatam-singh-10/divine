@extends('layouts.admin')
@push('title', get_phrase('Products'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <!-- Header with title -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-box me-2"></i>
                    <span>{{ get_phrase('Products') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <!-- Add New Product Button -->
                    <div class="col-md-12 text-end mb-3">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                            <i class="fi-rr-plus me-2"></i> {{ get_phrase('Add New Product') }}
                        </a>
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
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'products')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
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
                            <form action="{{ route('admin.products') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Products') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">
                                            {{ get_phrase('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    @if($products->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . $products->count() . ' ' . get_phrase('of') . ' ' . $products->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>

                        <div class="table-responsive course_list" id="product_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Product Name') }}</th>
                                        <th scope="col">{{ get_phrase('Category') }}</th>
                                        <th scope="col">{{ get_phrase('Price') }}</th>
                                         <th scope="col">{{ get_phrase('Image') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $product->name }}</h4>
                                                        <p class="sub-title2 text-12px">
                                                            {{ $product->created_at->format('d M, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="sub-title2 text-12px">{{ $product->category->name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="sub-title2 text-12px">${{ number_format($product->price, 2) }}</p>
                                            </td>
                                             <td>
                                            @if(!empty($product->image))
                                                <img src="{{ url($product->image) }}" alt="Product Image" height="50">
                                            @else
                                                <span class="text-muted">{{ get_phrase('No Image') }}</span>
                                            @endif
                                          </td>
                                            <td>
                                                <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('admin.products.edit', $product->id) }}">
                                                                {{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                 onclick="confirmModal('{{ route('admin.products.delete', $product->id) }}')"
                                                               href="javascript:void(0)">
                                                                {{ get_phrase('Delete') }}
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
                    @if ($products->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . $products->count() . ' ' . get_phrase('of') . ' ' . $products->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')@endpush
