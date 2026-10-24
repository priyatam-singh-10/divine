@extends('layouts.default')

@push('title', 'My Cart')

@section('content')
<div class="container mt-5 pb-5">
    <h2 class="g-title mb-5">My Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('message'))
        <div class="alert alert-warning">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->count() > 0)
        <form id="checkout-form" action="{{ route('bookpayout') }}" method="POST">
            
            @if($coupon && $couponDiscount > 0)
    <div class="alert alert-success d-flex justify-content-between align-items-center">
        <span>
            Coupon "{{ $coupon->code }}" applied! You get a <strong>{{ $couponDiscount }}% discount</strong>.
        </span>
        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-danger">Remove Coupon</a>
    </div>
@endif

            @csrf
            <div class="my-panel purchase-history-panel">
                <div class="table-responsive">
                    <table class="table eTable align-middle">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Price</th>
                                
                                <th>Qty</th>
                                <!--<th>Stocks</th>-->
                                <!--<th>Status</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $hasOutOfStock = false;
                            $allItemsOutOfStock = true; 
                            @endphp

                            @foreach($cartItems as $item)
                                @php
                                    $book = $item->book;
                                    if (!$book) continue;
                                    $images = json_decode($book->image ?? '[]', true);
                                    $coverImage = $images['cover'][0] ?? 'uploads/default-cover.png';
                                    $isOutOfStock = $book->stock <= 0;
                                   
                                     if ($isOutOfStock) {
                                            $hasOutOfStock = true;
                                        } else {
                                            $allItemsOutOfStock = false; // at least one item available
                                        }
                                                            
                                    // Individual book discount only (no coupon applied here)
                                    $bookDiscount = $book->discount_percentage ?? 0;
                                    $hasBookDiscount = $bookDiscount > 0;
                                    $bookFinalPrice = $hasBookDiscount
                                        ? $book->price - ($book->price * ($bookDiscount / 100))
                                        : $book->price;
                                
                                    $qty = $item->quantity ?? 1;
                                    $finalPrice = $bookFinalPrice * $qty; // No coupon applied per item
                                @endphp


                                <tr id="cart-item-{{ $item->id }}" 
                                    class="{{ $isOutOfStock ? 'table-danger' : '' }}"
                                    data-unit-price="{{ $isOutOfStock ? 0 : $bookFinalPrice  }}">
                                    <td>
                                        <img src="{{ asset($coverImage) }}" 
                                             alt="{{ $book->title }}" width="60">
                                    </td>
                                    <td>{{ $book->title }}
                                     @if($isOutOfStock)
                                        <div class="text-danger small mt-1">Out of stock</div>
                                    @endif
                                    </td>
                                     
                                    <td>{{ $book->author }}</td>
                                    
                                    <td>
                                        <div class="d-flex gap-3">
                                            @if($hasBookDiscount)
                                                <small class="text-muted">
                                                    <del>₹{{ number_format($book->price, 2) }}</del>
                                                </small> 
                                            @endif
                                            
                                            <strong>₹{{ number_format($bookFinalPrice, 2) }}</strong>
                                        
                                            @if($hasBookDiscount)
                                                <span class="badge bg-danger mt-1">
                                                    {{ rtrim(rtrim(number_format($bookDiscount, 2), '0'), '.') }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                     
                                     
                                    {{-- Quantity control --}}
                                    <td style="min-width:140px;">
                                        <div class="input-group input-group-sm cartQty">
                                            <button type="button" class="btn btn-outline-secondary qty-decrease" data-id="{{ $item->id }}">−</button>
                                            <input type="text" class="form-control text-center qty-input" 
                                                value="{{ $qty }}" 
                                                data-id="{{ $item->id }}" 
                                                min="1" 
                                                max="{{ $book->stock }}" 
                                                style="max-width:50px;">
                                            <button type="button" class="btn btn-outline-secondary qty-increase" data-id="{{ $item->id }}">+</button>
                                        </div>
                                    </td>
                                    <!--<td>-->
                                    <!--    {{-- Display available stocks --}}-->
                                    <!--    <span class="badge {{ $isOutOfStock ? 'bg-danger' : 'bg-info' }}">-->
                                            <!--{{ $book->stock }} in stock-->
                                    <!--    </span>-->
                                    <!--</td>-->
                                    
                                   


                                    <!--<td>-->
                                    <!--    @if($isOutOfStock)-->
                                    <!--        <span class="badge bg-danger">Out of Stock</span>-->
                                    <!--    @else-->
                                    <!--        <span class="badge bg-success">Available11</span>-->
                                    <!--    @endif-->
                                    <!--</td>-->
                                    <td>
                                        <button type="button" 
                                                class="btn btn-danger btn-lg remove-cart-item" 
                                                data-id="{{ $item->id }}">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!--@if($hasOutOfStock)-->
            <!--<div id="outOfStockAlert" class="alert alert-danger mt-3">-->
            <!--    ⚠️ Some books are out of stock and will not be included in checkout.-->
            <!--</div>-->
            <!--@endif-->
             
            <div class="text-end mt-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="coupon" placeholder="Apply coupon" value="{{ request()->query('coupon') }}">
                    <button type="button" id="apply-coupon" class="input-group-text eBtn gradient text-white">Apply</button>
                </div>
                <h4 class="fw-bold">Total: <span id="cart-total">₹0.00</span></h4>
                <button type="submit" id="checkoutBtn" class="eBtn btn gradient mt-3"  {{ ($cartItems->count() === 1 && $hasOutOfStock) ? 'disabled' : '' }} >
                    Proceed to Checkout
                </button>
            </div>
        </form>
    @else
        <p>Your cart is empty!</p>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    function formatINR(num) {
        return '₹' + Number(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

   function updateCartTotal() {
    let subtotal = 0;
    $('#checkout-form tbody tr').each(function() {
        const unitPrice = parseFloat($(this).data('unit-price')) || 0;
        const qty = parseInt($(this).find('.qty-input').val()) || 0;
        subtotal += unitPrice * qty;
    });

    const couponDiscount = {{ $couponDiscount ?? 0 }};
    const discountAmount = subtotal * (couponDiscount / 100);
    const grandTotal = subtotal - discountAmount;

    $('#cart-total').text(formatINR(grandTotal));
}



    updateCartTotal();
     $('#apply-coupon').click(function() {
        const code = $('input[name="coupon"]').val();
        window.location.href = "{{ route('cart.index') }}" + "?coupon=" + code;
    });
    // Qty increase
    $('.qty-increase').click(function() {
        const id = $(this).data('id');
        const $input = $(`.qty-input[data-id="${id}"]`);
        let val = parseInt($input.val()) || 1;
        const max = parseInt($input.attr('max')) || 10;
        if (val < max) {
            $input.val(val + 1).trigger('change');
        }
         else {
               toastr.warning('This product has reached its maximum available stock.', 'Stock Limit', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000,
                    positionClass: 'toast-top-right'
                });
            }
    });

    // Qty decrease
    $('.qty-decrease').click(function() {
        const id = $(this).data('id');
        const $input = $(`.qty-input[data-id="${id}"]`);
        let val = parseInt($input.val()) || 1;
        if (val > 1) {
            $input.val(val - 1).trigger('change');
        }
    });

    // On quantity change
    $('.qty-input').on('change', function() {
        const $input = $(this);
        const itemId = $input.data('id');
        const qty = parseInt($input.val()) || 1;
        const max = parseInt($input.attr('max')) || 10;

        if (qty < 1 || qty > max) {
            alert(`Quantity must be between 1 and ${max}`);
            $input.val(1);
            return;
        }

        @if(Auth::check())
        // Update quantity on server for logged-in users
        $.ajax({
            url: "{{ route('cart.updateQty') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                item_id: itemId, 
                quantity: qty
            },
            success: function(res) {
                updateCartTotal();
            },
            error: function() {
                alert('Error updating quantity.');
            }
        });
        @else
        // Guest users: update total locally
        updateCartTotal();
        @endif
    });

    // Remove item
    $('.remove-cart-item').click(function(){
        if(!confirm('Are you sure you want to remove this item?')) return;
        let itemId = $(this).data('id');
        let url = "{{ url('/cart') }}/" + itemId;
        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(){
                location.reload();
            }
        });
    });
});
</script>
@endsection
