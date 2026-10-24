@extends('layouts.default')

@push('title', get_phrase('Books'))
@push('meta')@endpush
@push('css')@endpush

@section('content')


<section class="breadcum-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="eNtry-breadcum">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="https://www.divinetouch.info">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                All Books
                            </li>
                        </ol>
                    </nav>

                    <div class="row row-gap-3">
                        <div class="col-auto col-md-4 col-lg-3">
                            <h3 class="g-title mt-2">All Books</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="book shop eNtery-item">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
             @include('frontend.default.book.filter')
            
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    @forelse($books as $book)
                    
                     @php
                        $images = json_decode($book->image, true);
                        $coverImage = $images['cover'][0] ?? 'uploads/default-cover.png'; // fallback
                        $discountedPrice = $book->discount_percentage  ? $book->price - ($book->price * ($book->discount_percentage / 100))  : $book->price;
                   
                      @endphp
            
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                            <div class="card Ecard eBar-card">
                                <div class="courses-img">
                                    <img src="{{ asset($coverImage) }}" alt="{{ $book->title }}" style="object-fit: unset;">
                                    <div class="cText d-flex">
                                        <h4>₹{{ number_format($discountedPrice, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="card-body entry-details mt-0 pb-0">
                                    <div class="entry-title">
                                        <h3 class="w-100 ellipsis-line-2 mb-0">{{ $book->title }}</h3>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    
                                    @if($book->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn eBtn btn-style1">
                                                    <i class="fa fa-shopping-cart me-2"></i>
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-danger py-2 mt-3 mb-0">
                                            <strong>Out of Stock!</strong> This book is currently unavailable.
                                        </div>
                                    @endif
                                   
                                
                                    <a href="{{ route('book.show', $book->slug) }}" class="learn-more text-center mt-10 d-block">
                                        View Details <i class="fa-solid fa-arrow-right-long ms-2"></i>
                                    </a>
                                </div>


                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No books found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- Add to <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Add before </body> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('message'))
        toastr.info("{{ session('message') }}");
    @endif
   
</script>

@endpush
