@extends('layouts.default')
@push('title', get_phrase('Shop'))
@push('meta')@endpush
@push('css')@endpush

@section('content')


<!------------------- Breadcum Area Start  ------>
<section class="breadcum-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="eNtry-breadcum">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Shop
                            </li>
                        </ol>
                    </nav>
                    <div class="row row-gap-3">
                        <div class="col-auto col-md-4 col-lg-3">
                            <h3 class="g-title mt-2">Shop</h3>
                        </div>
                        <div class="col-auto col-md-4 col-lg-4">
                            <span class="showing-text mt-4 d-inline-block">Showing 1 of 9 data</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!------------------- Breadcum Area End  --------->



<!-------------- List Item Start   --------------->
<div class="shop eNtery-item mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include('frontend.default.shop.filter')
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/bracelets.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Natural Tiger Eye Bracelet – Energy & Protection</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                   <!-- <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 6.01 4.01 4 6.5 4C8.24 4 9.91 5.1 10.44 6.68H13.55C14.09 5.1 15.76 4 17.5 4C19.99 4 22 6.01 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" 
                                                stroke="#6B7385" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </li>-->
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/crystalls.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Charged Intentional Healing Crystals</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/gemstones.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Certified Astrological Healing Gemstones</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/healing-candels.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Scented Healing Ritual Candles</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/healing-stones.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Reiki Charged Healing Stones</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/malas.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">108 Bead Meditation Malas</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/recharge-plates.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Copper Crystal Energy Plates</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/rudraksha.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Spiritual Energised Rudraksh Beads</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="card Ecard eBar-card">
                            <div class="courses-img">
                                <img src="https://divinetouch.info/public/uploads/shop/shreeyantra.webp" alt="shop-thumbnail">
                                <div class="cText d-flex">
                                    <h4> 999.00 ₹ </h4>
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-title="Add to wishlist" class="heart toggleWishItem" id="item-16"><i class="fa-regular fa-heart"></i></span>
                            </div>
                            <div class="card-body entry-details mt-0">
                                <div class="info-card mb-10">
                                    <div class="creator">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <p class="mt-0">Sold by Divine Touch Store</p>
                                    </div>
                                </div>
                                <div class="entry-title">
                                    <h3 class="w-100 ellipsis-line-2">Sacred Prosperity Shree Yantras</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="creator rating">
                                        <img src="https://divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="author-image">
                                        <span>4.4</span><i class="fa fa-star"></i> (120 reviews)
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="#" class="btn eBtn btn-style1">Add to Cart</a>
                            <div class="learn-more text-center">View Details <i class="fa-solid fa-arrow-right-long ms-2"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
                    
                    
                    

@endsection
@push('js')@endpush