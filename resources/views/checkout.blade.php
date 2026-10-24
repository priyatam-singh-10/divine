@extends('layouts.default')
@section('content')

<div class="payment-wrapper checkoutPage">
    <div class="payment-container">
        <div class="row g-0">
            <div class="col-lg-12">
                <div class="section-header pt-5 px-5 mb-0">
                    <h2>Complete Your Purchase</h2>
                    <p>Get instant access to your selected books</p>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6">
                <div class="right-section">
                    <!-- Also Available On -->
                    <div class="platforms-section borderSec">
                        <div class="section-label">Also Available On</div>
                        <div class="platform-links">
                            <a href="https://www.amazon.in/dp/B0FLK5DYVS/" target="_blank" class="platform-link">
                                <img src="public/assets/frontend/default/image/amazon_kindal_logo.png" alt="Amazon" class="platform-logo">
                            </a>
                            <a href="https://www.flipkart.com/product/p/itme?pid=RBKHEQS8DEQPV4C6" target="_blank" class="platform-link">
                                <img src="public/assets/frontend/default/image/flipkart_logo.png" alt="Flipkart" class="platform-logo">
                            </a>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="platforms-section borderSec">
                        <!-- Shipping Address -->
                        <div class="platforms-section">
                            <div class="section-label">Shipping Info</div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4 col-sm-4 col-12">
                                    <div class="mb-3">
                                        <label for="shipping_name" class="form-label fw-bold">Name</label>
                                        <input type="text" id="shipping_name" name="shipping_name" class="form-control"
                                               placeholder="Enter your name" value="{{ $user->name ?? '' }}" maxlength="50" required>
                                        <div id="shipping_name-error" class="text-danger mt-1" style="display: none;">Name!</div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-12">
                                    <div class="mb-3">
                                        <label for="shipping_email" class="form-label fw-bold">Email</label>
                                        <input type="text" id="shipping_email" name="shipping_email" class="form-control"
                                        placeholder="Enter your email" value="{{ $user->email ?? '' }}" maxlength="50" required>
                                        <div id="shipping_email-error" class="text-danger mt-1" style="display: none;">Email!</div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-12">
                                    <div class="mb-3">
                                        <label for="shipping_contact" class="form-label fw-bold">Contact Number</label>
                                        <input type="text" id="shipping_contact" name="shipping_contact" class="form-control"
                                               placeholder="Enter your contact number" value="{{ $user->phone ?? '' }}"required>
                                        <div id="shipping_contact-error" class="text-danger mt-1" style="display: none;">Contact number is required!</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="section-label">Shipping Address</div>
                        
                            <div class="row g-3 mb-3">
                                <!-- Country -->
                                <div class="col-md-4 col-sm-4 col-12">
                                    <label for="country" class="form-label fw-bold">Country</label>
                                    <select id="country" name="country" class="form-control" required>
                                        <option value="">Select Country</option>
                                        @foreach(DB::table('countries')->orderBy('name')->get() as $country)
                                            <option value="{{ $country->id }}"
                                                {{ (isset($user->full_address['country']) && $user->full_address['country'] == $country->id) ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                     <div id="country-error" class="text-danger mt-1" style="display: none;">Country required!</div>
                                </div>
                            
                                <!-- State -->
                                <div class="col-md-4 col-sm-4 col-12">
                                    <label for="state" class="form-label fw-bold">State</label>
                                    <select id="state" name="state" class="form-control" required>
                                        <option value="">Select State</option>
                                        @if(isset($user->full_address['state']))
                                            @foreach(DB::table('states')->where('country_id', $user->full_address['country'])->orderBy('name')->get() as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ $user->full_address['state'] == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div id="state-error" class="text-danger mt-1" style="display: none;">State required!</div>
                                </div>
                            
                                <!-- City -->
                                <div class="col-md-4 col-sm-4 col-12">
                                    <label for="city" class="form-label fw-bold">City</label>
                                    <select id="city" name="city" class="form-control" required>
                                        <option value="">Select City</option>
                                        @if(isset($user->full_address['city']))
                                            @foreach(DB::table('cities')->where('state_id', $user->full_address['state'])->orderBy('name')->get() as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ $user->full_address['city'] == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div id="city-error" class="text-danger mt-1" style="display: none;">City required!</div>
                                </div>
                            
                                <!-- Address Line -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address_line" class="form-label fw-bold">Address Line</label>
                                        <textarea id="address_line" name="address_line" class="form-control" rows="2"
                                                  placeholder="Street, apartment, etc." required>{{ $user->full_address['address'] ?? '' }}</textarea>
                                    </div>
                                     <div id="address_line-error" class="text-danger mt-1" style="display: none;">Address Line is required!</div>
                                </div>
                                
                                <!-- ZIP Code -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <label for="zipcode" class="form-label fw-bold">ZIP Code</label>
                                    <input type="text" id="zipcode" name="zipcode" class="form-control"
                                           value="{{ $user->full_address['zipcode'] ?? '' }}" required>
                                           <div id="zipcode-error" class="text-danger mt-1" style="display: none;">ZipCode required!</div>
                                </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div>
                
                <div class="left-section d-none">
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach($cartItems as $item)
                        @php
                           $qty = $item->quantity ?? 1;
     
                            $book = $item->book;
                            $images = json_decode($book->image ?? '[]', true);
                            $coverImage = $images['cover'][0] ?? 'uploads/default-cover.png';
                          
                        @endphp
                        <div class="book-image-wrapper mb-3">
                            <img src="{{ $coverImage ? asset($coverImage) : asset('assets/frontend/default/image/placeholder.png') }}" 
                                 alt="{{ $book->title }}" class="book-cover">
                            <div class="book-info mt-2">
                                <h1 class="book-title">{{ $book->title }}</h1>
                                <p class="book-author">{{ $book->author ?? 'Anonymous' }}</p>
                                <p class="text-white">Quantity: {{ $qty }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Payment Details -->
            <div class="col-lg-6 col-md-6">
                <div class="right-section">
                    <div>
                  <!-- Price Breakdown -->
                    <div class="price-card">
                        @php
                            $grandTotal = 0;
                            $totalSaved = 0;
                        @endphp
                    
                        @foreach($cartItems as $item)
                            @php
                                $book = $item->book;
                                $qty = $item->quantity ?? 1;
                                $discount = $book->discount_percentage ?? 0;
                                $hasDiscount = $discount > 0;
                    
                                $discountedAmount = ($book->price * ($discount / 100)) * $qty;
                                $finalPrice = ($book->price - ($book->price * ($discount / 100))) * $qty;
                    
                                $grandTotal += $finalPrice;
                                $totalSaved += $discountedAmount;
                    
                                $images = json_decode($book->image ?? '[]', true);
                                $coverImage = $images['cover'][0] ?? 'uploads/default-cover.png';
                            @endphp
                    
                            <div class="d-flex gap-3">
                                <img src="{{ $coverImage ? asset($coverImage) : asset('assets/frontend/default/image/placeholder.png') }}" 
                                    alt="{{ $book->title }}" class="book-cover">
                    
                                <div class="price-item">
                                    <span class="price-label">{{ $book->title }} (x{{ $qty }})</span>
                                    <span class="price-value price-original">₹{{ number_format($book->price * $qty, 2) }}</span>
                                </div>
                            </div>
                    
                            @if($hasDiscount)
                                <div class="discount-label">
                                    <span class="price-label">
                                        Discount ({{ rtrim(rtrim(number_format($discount, 2), '0'), '.') }}%)
                                    </span>
                                    <span class="price-value text-success">
                                        -₹{{ number_format($discountedAmount, 2) }}
                                    </span>
                                </div>
                            @endif
                    
                            <div class="price-item mb-4">
                                <span class="price-label fw-bold text-dark">Total Amount</span>
                                <span class="price-final">
                                    ₹{{ number_format($finalPrice, 2) }}
                                    @if($hasDiscount)
                                        <span class="discount-badge">
                                            SAVE {{ rtrim(rtrim(number_format($discount, 2), '0'), '.') }}%
                                        </span>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    
                        <!-- Coupon Discount & Grand Total -->
                        @php
                            $couponDiscountAmount = 0;
                            if (!empty($coupon) && ($couponDiscount ?? 0) > 0) {
                                // Apply coupon discount on grand total
                                $couponDiscountAmount = ($grandTotal * ($coupon->discount / 100));
                            }
                            $finalGrandTotal = $grandTotal - $couponDiscountAmount;
                        @endphp
                    
                        <div style="padding: 0px 12px; border-radius: 8px; border: 1px dashed var(--teal);">
                            @if($couponDiscountAmount > 0)
                                <div class="price-item mt-2">
                                    <span class="price-label">Coupon Discount ({{ $coupon->discount }}%)</span>
                                    <span class="price-value text-success">-₹{{ number_format($couponDiscountAmount, 2) }}</span>
                                </div>
                            @endif
                    
                            <div class="price-item mt-2">
                                <span class="price-label fw-bold text-dark">Grand Total</span>
                                <span class="price-final fw-bold text-success">
                                    ₹{{ number_format($finalGrandTotal, 2) }}
                                </span>
                            </div>
                    
                            @if($totalSaved > 0 || $couponDiscountAmount > 0)
                                <div class="price-item">
                                    <span class="price-label fw-medium text-muted">You Saved</span>
                                    <span class="price-value text-success">
                                        ₹{{ number_format($totalSaved + $couponDiscountAmount, 2) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>


                        <!-- Features Grid -->
                        <!--<div class="features-grid">-->
                        <!--    <div class="feature-box">-->
                        <!--        <i class="fas fa-check"></i>-->
                        <!--        <span class="feature-text">Instant Access</span>-->
                        <!--    </div>-->
                        <!--    <div class="feature-box">-->
                        <!--        <i class="fas fa-check"></i>-->
                        <!--        <span class="feature-text">Lifetime Validity</span>-->
                        <!--    </div>-->
                        <!--    <div class="feature-box">-->
                        <!--        <i class="fas fa-check"></i>-->
                        <!--        <span class="feature-text">All Devices</span>-->
                        <!--    </div>-->
                        <!--    <div class="feature-box">-->
                        <!--        <i class="fas fa-check"></i>-->
                        <!--        <span class="feature-text">24/7 Support</span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="divider"></div>-->

                        <!-- Payment Methods -->
                        <div class="platforms-section">
                            <div class="section-label">We Accept</div>
                            <div class="payment-methods">
                                <img src="public/assets/frontend/default/image/visa.png" alt="Visa" class="payment-logo">
                                <img src="public/assets/frontend/default/image/master_card.png" alt="Mastercard" class="payment-logo">
                                <img src="public/assets/frontend/default/image/rupay.png" alt="RuPay" class="payment-logo">
                                <img src="public/assets/frontend/default/image/upi.png" alt="UPI" class="payment-logo">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <div>
                        <button id="rzp-button" class="checkout-button">
                            <i class="bi bi-shield-lock-fill me-2"></i>
                            Proceed to Secure Payment
                        </button>
                        <div class="secure-badge">
                            <i class="bi bi-shield-check-fill"></i>
                            <span>256-bit SSL Encrypted | 100% Safe & Secure</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toastr CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Razorpay Checkout -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

   const addressField = document.getElementById('address_line');
   const contactField = document.getElementById('shipping_contact');
var options = {
    "key": "{{ $key }}", 
    "amount": "{{ intval($grandTotal * 100) }}",
    "currency": "INR",
    "name": "Book Store",
    "description": "Payment for {{ $cartItems->count() }} book(s)",
    "order_id": "{{ $order_id }}", 
    "handler": function (response){
        fetch("{{ route('bookpaymentverify') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature,
                cart_items: @json($cartItems->pluck('id')),
                total_amount: "{{ intval($grandTotal * 100) }}",
                shipping_address: addressField.value.trim(),  
                shipping_contact: contactField.value.trim(),
                shipping_contact: document.getElementById('shipping_contact').value.trim(),
                shipping_name: document.getElementById('shipping_name').value.trim(),
                shipping_email: document.getElementById('shipping_email').value.trim(),
                full_shippingaddress: {
                    address: document.getElementById('address_line').value.trim(),
                    city: document.querySelector('#city option:checked').text,
                    state: document.querySelector('#state option:checked').text,
                    country: document.querySelector('#country option:checked').text,
                    zipcode: document.getElementById('zipcode').value.trim()
                }   
            })
        }).then(res => res.json()).then(data => {
            if(data.success) {
                toastr.success(data.message, 'Payment Success', { 
                    positionClass: "toast-top-right",
                    timeOut: 1200 
                });
                setTimeout(function(){
                    window.location.href = "{{ route('book.orders') }}";
                }, 1200);
            } else {
                toastr.error(data.message, 'Payment Failed', { 
                    positionClass: "toast-top-right",
                    timeOut: 3000 
                });
            }
        });
    },
    "theme": {
        "color": "#667eea"
    },
    "modal": {
        "ondismiss": function() {
            window.location.href = "{{ route('cart.index') }}"; // redirect to cart after cancel
        }
    }
};

document.getElementById('rzp-button').onclick = function(e){
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
</script>

<script>

// Name validation - only allow letters and spaces
document.querySelector('input[name="shipping_name"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
    e.target.value = value;
});

// Email validation - check for valid email pattern
document.querySelector('input[name="shipping_email"]').addEventListener('input', function(e) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const value = e.target.value.trim();
    const errorElem = document.getElementById('shipping_email-error');
    if (value === '') {
        errorElem.textContent = 'Email is required!';
        errorElem.style.display = 'block';
    } else if (!emailRegex.test(value)) {
        errorElem.textContent = 'Please enter a valid email!';
        errorElem.style.display = 'block';
    } else {
        errorElem.style.display = 'none';
    }
});

// Phone number validation - only allow digits, max 10
document.querySelector('input[name="shipping_contact"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 13) {
        value = value.slice(0, 13);
    }
    e.target.value = value;
    const errorElem = document.getElementById('shipping_contact-error');
    if (value === '') {
        errorElem.textContent = 'Contact number is required!';
        errorElem.style.display = 'block';
    } else if (value.length !== 13) {
        errorElem.textContent = 'Contact number must be correct!';
        errorElem.style.display = 'block';
    } else {
        errorElem.style.display = 'none';
    }
});

// Zipcode validation - only allow digits, max 6 (Indian pincode)
document.querySelector('input[name="zipcode"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 6) {
        value = value.slice(0, 6);
    }
    e.target.value = value;
    const errorElem = document.getElementById('zipcode-error');
    if (value === '') {
        errorElem.textContent = 'ZIP code is required!';
        errorElem.style.display = 'block';
    } else if (value.length !== 6) {
        errorElem.textContent = 'ZIP code must be 6 digits!';
        errorElem.style.display = 'block';
    } else {
        errorElem.style.display = 'none';
    }
});


</script>

<script>
const requiredFields = [
    { id: 'shipping_name', errorId: 'shipping_name-error', message: 'Name is required!', validate: (value) => value.trim() !== '' },
    { id: 'shipping_email', errorId: 'shipping_email-error', message: 'Email is required!', validate: (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    }},
    { id: 'shipping_contact', errorId: 'shipping_contact-error', message: 'Contact number is required!', validate: (value) => value.trim().length === 13 },
    { id: 'address_line', errorId: 'address_line-error', message: 'Address is required!', validate: (value) => value.trim() !== '' },
    { id: 'country', errorId: 'country-error', message: 'Country is required!', validate: (value) => value.trim() !== '' },
    { id: 'state', errorId: 'state-error', message: 'State is required!', validate: (value) => value.trim() !== '' },
    { id: 'city', errorId: 'city-error', message: 'City is required!', validate: (value) => value.trim() !== '' },
    { id: 'zipcode', errorId: 'zipcode-error', message: 'ZIP code is required!', validate: (value) => value.trim().length === 6 },
];

const payButton = document.getElementById('rzp-button');

function toggleButton() {
    let allValid = true;
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        const errorElem = document.getElementById(field.errorId);
        const value = input.value.trim();
        if (value === '') {
            errorElem.textContent = field.message;
            errorElem.style.display = 'block';
            allValid = false;
        } else if (!field.validate(value)) {
            if (field.id === 'shipping_contact') {
                errorElem.textContent = 'Contact number must be correct!';
            } else if (field.id === 'zipcode') {
                errorElem.textContent = 'ZIP code must be 6 digits!';
            } else if (field.id === 'shipping_email') {
                errorElem.textContent = 'Please enter a valid email!';
            }
            errorElem.style.display = 'block';
            allValid = false;
        } else {
            errorElem.style.display = 'none';
        }
    });
    payButton.disabled = !allValid;
}

// Run on load
toggleButton();

// Listen for changes
requiredFields.forEach(field => {
    document.getElementById(field.id).addEventListener('input', toggleButton);
    document.getElementById(field.id).addEventListener('change', toggleButton);
});


</script>

<script>
$(document).ready(function() {
    $('#country').on('change', function() {
        let countryId = $(this).val();
        $('#state').html('<option value="">Select State</option>');
        $('#city').html('<option value="">Select City</option>');

        if(countryId) {
            $.get('/states/' + countryId, function(states) {
                $.each(states, function(key, state) {
                    $('#state').append('<option value="'+ state.id +'">'+ state.name +'</option>');
                });
            });
        }
    });

    $('#state').on('change', function() {
        let stateId = $(this).val();
        $('#city').html('<option value="">Select City</option>');

        if(stateId) {
            $.get('/cities/' + stateId, function(cities) {
                $.each(cities, function(key, city) {
                    $('#city').append('<option value="'+ city.id +'">'+ city.name +'</option>');
                });
            });
        }
    });
});
</script>
@endsection
