@extends('layouts.default')

@push('title', get_phrase('Book Details'))


  @php
    $og_title = $book->title;
    $og_description = Str::limit(strip_tags($book->description), 150);
    $og_image = asset($book->cover_image); 
    $facebookappid="791582523789795";
    
     $images = json_decode($book->image, true);
     $video = $book->video_url; // Example: https://www.youtube.com/watch?v=zB2Dsy63cAI&list=PPSV

    // Parse the URL and extract query parameters
    $queryString = parse_url($video, PHP_URL_QUERY);
    parse_str($queryString, $queryParams);

    // Get the video ID
    $videoId = $queryParams['v'] ?? null;
    
    $discountedPrice = $book->discount_percentage  ? $book->price - ($book->price * ($book->discount_percentage / 100))  : $book->price;
 
@endphp
@push('meta')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $og_title }}" />
    <meta property="og:description" content="{{ $og_description }}" />
    <meta property="og:image" content="{{ $og_image }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="fb:app_id" content="{{ $facebookappid}}" />
@endpush
@push('css')
@endpush

@section('content')

<!-- Breadcrumb -->
<section class="breadcum-area page-content-pb-100 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 px-4">
                <div class="eNtry-breadcum mt-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb d-flex flex-nowrap">
                            <li class="breadcrumb-item"><a href="https://www.divinetouch.info">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item ellipsis-line-1 active" aria-current="page">{{ $book->title }} </li>
                        </ol>
                    </nav>
                </div>

                <div class="course-details pe-auto pe-lg-5">
                    <div class="row row-gap-4">
                        <div class="col-6 col-sm-6 col-md-4">
                            <a class="d-flex align-items-center text-dark" href="https://www.divinetouch.info/instructor-details/Dr-Mahaveer-Gautam/1">
                                <img class="pro-32 me-2" src="https://www.divinetouch.info/public/uploads/users/admin/0lb6YXqIOrA6g9k07yK0.png" alt="instructor-image">
                                Dr. Mahaveer Gautam
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 d-flex align-items-center text-dark">
                            <img class="pro-20 me-2" src="https://www.divinetouch.info/public/assets/frontend/default/image/language.png" alt="...">
                            English / Hindi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Book Details -->

<section class="page-content-pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                 <div class="bookDetails details-page-content">
                    <div class="ps-box static-menu mt-5 w-100">
                        <ul class="nav nav-bordered" id="pills-tab" role="tablist">
                            <li class="nav-item active" role="presentation">
                                <button class="nav-link active" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview" aria-selected="true">{{ get_phrase('Overview') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-author-tab" data-bs-toggle="pill" data-bs-target="#pills-author" type="button" role="tab" aria-controls="pills-author" aria-selected="true">{{ get_phrase('Author') }}</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                                @if (!empty($book->description))
                                    <p class="book-description"> {!! removeScripts($book->description) !!}
                                @else
                                    <p class="text-center">{{ get_phrase('No description available.') }}</p>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-author" role="tabpanel" aria-labelledby="pills-author-tab" tabindex="0">
                                @if (!empty($book->author))
                                    <p class="book-author py-4 fw-bold"> {!! removeScripts($book->author) !!}
                                       <p class="book-author"> {!! removeScripts($book->author_desc) !!}
                                @else
                                    <p class="text-center">{{ get_phrase('No details available.') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="gradient-border radius-22" style="z-index: 6;position: relative; margin-top: -70px;">
                    <div class="ps-box ps-sidebar">
                        <div class="hero-details position-relative pt-3 pb-4 mt-0">
                            <div class="book-carousel owl-carousel owl-theme">
                                <!-- Cover Image -->
                                @if(isset($images['cover'][0]))
                                    <div>
                                        <img src="{{ asset($images['cover'][0]) }}"
                                             alt="Cover"
                                             class="carousel-image"
                                             data-index="0"
                                             onclick="openImageModal(0)"
                                             style="cursor: pointer;">
                                    </div>
                                @endif
                                <!-- Back Image -->
                                @if(isset($images['back'][0]))
                                    <div>
                                        <img src="{{ asset($images['back'][0]) }}"
                                             alt="Back"
                                             class="carousel-image"
                                             data-index="1"
                                             onclick="openImageModal(1)"
                                             style="cursor: pointer;">
                                    </div>
                                @endif
                                <!-- Extra Images -->
                                @if(isset($images['extra_img']))
                                    @foreach($images['extra_img'] as $index => $image)
                                        <div>
                                            <img src="{{ asset($image) }}"
                                                 alt="Extra Image {{ $index + 1 }}"
                                                 class="carousel-image"
                                                 data-index="{{ $index + 2 }}"
                                                 onclick="openImageModal({{ $index + 2 }})"
                                                 style="cursor: pointer;">
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Video Thumbnail -->
                                <div>
                                    <div class="video-testimonial-card"
                                         style="background-image: url('https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg')"
                                         onclick="openVideoModal('{{ $videoId }}')">
                                        <div class="play-button">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!-- Price Section with Discount -->
                        <div class="ps-price d-flex flex-column">
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="g-title text-success mb-0">₹{{ number_format($discountedPrice, 2) }}</h4>
                        
                                @if($book->discount_percentage > 0)
                                    <span class="text-muted text-decoration-line-through">₹{{ number_format($book->price, 2) }}</span>
                                    <span class="badge bg-danger">
                                        {{ rtrim(rtrim(number_format($book->discount_percentage, 2), '0'), '.') }}% OFF
                                    </span>
                                @endif
                            </div>
                            <small class="text-muted">MRP: ₹{{ number_format($book->price, 2) }} (Inclusive of all taxes)</small>
                        </div>

                        
                        
                        @if (!auth()->check() || (auth()->check() && auth()->user()->role != 'admin'))
            
                        @if($book->stock > 0 && $book->status === 'active')
                            <!-- Flipkart Buy Button -->
                            <a href="https://www.flipkart.com/product/p/itme?pid=RBKHEQS8DEQPV4C6" target="_blank" class="eBtn w-100 mb-2" style="background: linear-gradient(45deg, #2874f0, #1e5dc9); color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; border-radius: 8px;">
                                {{ get_phrase('Buy on Flipkart') }}
                            </a>
                            
                            <!-- Amazon Buy Button (Audio Book) -->
                            <a href="https://www.amazon.in/dp/B0FLK5DYVS/" target="_blank" class="eBtn w-100 mb-2" style="background: linear-gradient(45deg, #ff9900, #ff7700); color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; border-radius: 8px;">
                               Buy eBook on Amazon
                            </a>
                        @else
                            <div class="alert alert-warning text-center">{{ get_phrase('Not available for purchase') }}</div>
                        @endif

                        <!--@if($book->stock > 0 && $book->status === 'active')-->
                        <!--    <a href="#" class="btn btn-primary btn-lg w-100 mb-3">{{ get_phrase('Buy Now') }}</a>-->
                        <!--@else-->
                        <!--    <div class="alert alert-warning text-center">{{ get_phrase('Not available for purchase') }}</div>-->
                        <!--@endif-->

                        <!--<span class="eBtn border learn-btn w-100 cursor-pointer mt-3 toggleWishItem mb-0" onclick="wishlistToggleButton('21', this)">-->
                        <!--Buy Now</span>-->
                        <!--<a href="#" class="eBtn gradient w-100 mt-3 mb-0" style="cursor: not-allowed;" disabled>-->
                        <!--   <i class="fas fa-clock me-2"></i>-->
                        <!--   Buy Now - Coming Soon-->
                        <!--</a>-->
                        
                        @if($book->stock > 0 && $book->status === 'active')
                            <!--<form id="payoutForm" method="POST" action="{{ route('bookpayout') }}">-->
                            <!--    @csrf-->
                            <!--    <input type="hidden" name="book_id" value="{{ $book->id }}">-->
                            <!--    <input type="hidden" name="price" value="{{ $book->price }}">-->
                            <!--    <button type="submit" class="eBtn gradient w-100 mt-3 mb-0">-->
                            <!--        {{ get_phrase('Buy Now') }}-->
                            <!--    </button>-->
                            <!--</form>-->
                            
                              <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="eBtn gradient w-100 mt-3 mb-0">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning text-center">{{ get_phrase('Not available for purchase') }}</div>
                        @endif
                        @endif
                                                    
                        <ul class="ps-side-feature mt-2">
                            <li class="d-flex justify-content-between align-items-center py-3 mb-0">
                                <span>
                                    <img src="https://www.divinetouch.info/public/assets/frontend/default/image/language2.png" alt="...">
                                    <p>language</p>
                                </span>
                                English / Hindi
                            </li>
                        </ul>

                         @php
                        // Get user reference if exists
                        $ref = $user_data['unique_identifier'] ?? '';

                        // Generate the shareable URL using book Slug
                        $share_url = url('/book/' . $book->slug);
                        @endphp

                        <div class="w-100 px-4 pb-2 text-center mt-3">
                            <span>Share :</span>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}"
                                target="_blank" class="p-2 mx-2 color-facebook" data-bs-toggle="tooltip" data-bs-placement="top"
                                aria-label="Share on Facebook" data-bs-original-title="Share on Facebook">
                                <i class="fab fa-facebook text-20"></i>
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}"
                                target="_blank" class="p-2 mx-2 color-whatsapp" data-bs-toggle="tooltip" data-bs-placement="top"
                                aria-label="Share on Whatsapp" data-bs-original-title="Share on Whatsapp">
                                <i class="fab fa-whatsapp text-20"></i>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ urlencode($book->title) }}&summary={{ urlencode($book->short_desc) }}&ref={{ $ref }}"
                                target="_blank" class="p-2 mx-2 color-linkedin" data-bs-toggle="tooltip" data-bs-placement="top"
                                aria-label="Share on Linkedin" data-bs-original-title="Share on Linkedin">
                                <i class="fab fa-linkedin text-20"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section
    
<!-- Image Modal -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Update the modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#imageModal').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center position-relative">
                <img id="modalImage" src="" alt="Preview" class="img-fluid">
                
                <!-- Navigation Arrows -->
                <button class="modal-nav-btn modal-prev" onclick="navigateImage(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="modal-nav-btn modal-next" onclick="navigateImage(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Image Counter -->
                <div class="image-counter">
                    <span id="currentImageIndex">1</span> / <span id="totalImages">6</span>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Video Modal -->
<div id="videoModal" class="video-modal">
    <div class="video-modal-content">
        <div class="video-modal-header">
            <h5 id="videoTitle">Untold Secrets of Wealth: The Eternal Key of Abundancel</h5>
            <button class="close-modal" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="video-modal-body">
            <iframe id="videoFrame" src="" allowfullscreen></iframe>
        </div>
    </div>
</div>


<section class="testimonials-section section-padding">
    <div class="container">
        <div class="section-title fade-in-up text-center">
            <h2 class="title">What Our Readers Say</h2>
            <p>Don't just take our word for it – hear from our readers who have enjoyed and benefited from this book firsthand.</p>
        </div>

        <div class="tab-content" id="testimonialTabContent">
            <div class="tab-pane fade show active" id="text-testimonials" role="tabpanel">
                <div class="owl-carousel text-testimonials-carousel">
                    <div class="text-testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text collapsed" data-full-text="डाँ महावीर गोतम जी द्बारा लिखित पुस्तक धन के अनकहें रहस्य आप को एक ऐसी यात्रा पर ले जाते हैं , जहां आप अपनी मानसिक ऊर्जा और कर्मों के प्रचुरता के साथ जोड़कर अपने सपनों को 
हकीकत में बदल सकते हैं । जीवन में बचत और निवेश कैसे करें समय और धन का उपयोग कहा और कैसे करें , मुझे इस पुस्तक को पढ़ने के बाद बहुत कुछ ज्ञान सिख">
                                डाँ महावीर गोतम जी द्बारा लिखित पुस्तक धन के अनकहें रहस्य आप को एक ऐसी यात्रा पर ले जाते हैं , जहां आप अपनी मानसिक ऊर्जा और कर्मों के प्रचुरता के साथ जोड़कर अपने सपनों को 
हकीकत में बदल सकते हैं । जीवन में बचत और निवेश कैसे करें समय और धन का उपयोग कहा और कैसे करें , मुझे इस पुस्तक को पढ़ने के बाद बहुत कुछ ज्ञान सिखने को मिला है ।

                            </p>
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">GS</div>
                            <div class="client-details">
                                <h3>गोरी शंकर रूद्राक्ष जोशी </h3>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text collapsed">
                                शीर्षक से परे, 'धन के अनकहे रहस्य : समृद्धि की अचूक कुंजी' पढ़ने पर मुझे ऐसा लगा कि इस किताब में धन कमाने के उपायों से ज़्यादा, आध्यात्मिकता के साथ आत्मबल एवं अपनी समस्त शक्तियों को केंद्रित कर लक्ष्य के प्रति अग्रसर होने के तरीके इस प्रकार से दिए गए हैं कि यदि आप इनमें से कुछ तरीकों को भी अपनाएँ और निरंतरता से प्रयास करें, तो सफलता आसानी से प्राप्त की जा सकती है।
ब्रह्मांड का सनातन सत्य, जिसके अनुसार जो आप सोचते हैं, महसूस करते हैं और विश्वास करते हैं, वही आपके जीवन में आकर्षित होता है, एक चुंबक की तरह कार्य करता है - यह वास्तव में सत्य है।
किताब में वर्णित अनेक तरीकों को पढ़कर महसूस हुआ कि वे नकारात्मकता का दमन कर सकारात्मकता एवं आध्यात्मिकता की ओर ले जाते हैं, जो न केवल आत्मबल बढ़ाते हैं बल्कि आत्मसंतुष्टि का मार्ग भी बताते हैं।
प्रेरणादायक पुस्तक के लिए आपको साधुवाद और शुभकामनाएँ।
                            </p>
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">NG</div>
                            <div class="client-details">
                                <h3>Nidhi Gandhi</h3>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text collapsed" data-full-text="">
                                डॉ. महावीर गौतम की यह पुस्तक केवल धन प्राप्ति की नहीं, बल्कि आध्यात्मिक और आंतरिक समृद्धि की यात्रा है। इसमें प्राचीन भारतीय ज्ञान और आधुनिक विज्ञान का अद्भुत समन्वय है, जो सिखाता है कि सच्ची प्रचुरता हमारे भीतर की चेतना से उत्पन्न होती है।
30-दिन के अभ्यासों के माध्यम से यह पुस्तक पाठक को आत्म- परिवर्तन, सकारात्मक ऊर्जा और आत्मविश्वास की दिशा में प्रेरित करती है....
                            </p>
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">SS</div>
                            <div class="client-details">
                                <h3>डॉ. सुदेश शर्मा</h3>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text collapsed" data-full-text="">
                                डॉ. महावीर गौतम जी के द्वारा लिखित" धन के अनकहे रहस्य सम्रद्धि की अचूक कुंजी" शीर्षक वाली पुस्तक बहुत ही अच्छी, प्रासंगिक, ज्ञानवर्धक और वर्तमान में अत्यंत ही उपयोगी है। यह प्रेरक, धन का संतुलित प्रबन्धन, धन के अर्जन के सत्य तरीके, उसके उपयोग आदि विषयों पर विस्तार से प्रकाश डालती है, जो आज के प्रत्येक व्यक्ति के लिए आर्थिक दृष्टि से ही नहीं अपितु मानसिक और आध्यात्मिक आदि दृष्टियों से भी अत्यंत उपादेय है।
मुझे पूर्ण विश्वास है कि इस पुस्तक के पढ़ने के उपरांत भारतवर्ष के आम आदमी की दशा और दिशा जीवन के सभी क्षेत्रों में बदलेगी एवं उसे नया व्यक्तित्व से सम्पन्न बनायेगी।
पुस्तक प्रकाशन हेतु गौतम जी को सपरिवार हार्दिक बधाई और शुभकामनाएं।प्रेरित करती है....
                            </p>
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">BLM</div>
                            <div class="client-details">
                                <h3>Dr. Babu Lal Meena</h3>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@push('js')

<script>

let currentImageIndex = 0;
let imageElements = [];

// Initialize image array on page load
document.addEventListener('DOMContentLoaded', function() {
    imageElements = document.querySelectorAll('.carousel-image');
    document.getElementById('totalImages').textContent = imageElements.length;
});

function openImageModal(index) {
    currentImageIndex = index;
    updateModalImage();
    $('#imageModal').modal('show');
}

function updateModalImage() {
    if (imageElements.length > 0) {
        const img = imageElements[currentImageIndex];
        document.getElementById('modalImage').src = img.src;
        document.getElementById('currentImageIndex').textContent = currentImageIndex + 1;
    }
}

function navigateImage(direction) {
    currentImageIndex += direction;
    
    // Loop around if at start or end
    if (currentImageIndex < 0) {
        currentImageIndex = imageElements.length - 1;
    } else if (currentImageIndex >= imageElements.length) {
        currentImageIndex = 0;
    }
    
    updateModalImage();
}

// Keyboard navigation (left/right arrow keys)
document.addEventListener('keydown', function(e) {
    if ($('#imageModal').hasClass('show')) {
        if (e.key === 'ArrowLeft') {
            navigateImage(-1);
        } else if (e.key === 'ArrowRight') {
            navigateImage(1);
        }
    }
});



// YouTube Video Modal Functions (moved outside document.ready)
    function openVideoModal(videoId, title) {
        const modal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');
        const videoTitle = document.getElementById('videoTitle');
        
        if (!modal || !videoFrame || !videoTitle) {
            console.error('Modal elements not found');
            return;
        }
        
        videoTitle.textContent = title || 'Untold Secrets of Wealth: The Eternal Key of Abundancel';
        videoFrame.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
        
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');
        
        if (!modal || !videoFrame) {
            console.error('Modal elements not found');
            return;
        }
        
        modal.style.display = 'none';
        modal.classList.remove('show');
        videoFrame.src = '';
        document.body.style.overflow = 'auto';
    }
    
     // Event listeners for modal
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('videoModal');
        if (event.target === modal) {
            closeVideoModal();
        }
    });
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeVideoModal();
        }
    });
</script>

<script>
    // Function to toggle text visibility
    function toggleText(button) {
        const testimonialText = button.previousElementSibling;
        const isCollapsed = testimonialText.classList.contains('collapsed');
        
        if (isCollapsed) {
            testimonialText.classList.remove('collapsed');
            button.textContent = 'View less';
        } else {
            testimonialText.classList.add('collapsed');
            button.textContent = 'View more';
        }
    }

    // Function to check if text exceeds 5 lines and show/hide view more button
    function checkTextHeight() {
        const testimonialTexts = document.querySelectorAll('.testimonial-text');
        
        testimonialTexts.forEach(function(textElement) {
            const button = textElement.nextElementSibling;
            if (!button || !button.classList.contains('view-more-btn')) return;
            
            // Create a temporary element to measure the actual height
            const tempDiv = document.createElement('div');
            tempDiv.style.cssText = `
                position: absolute;
                visibility: hidden;
                height: auto;
                width: ${textElement.offsetWidth}px;
                font-size: ${window.getComputedStyle(textElement).fontSize};
                font-family: ${window.getComputedStyle(textElement).fontFamily};
                line-height: ${window.getComputedStyle(textElement).lineHeight};
                padding: ${window.getComputedStyle(textElement).padding};
                margin: ${window.getComputedStyle(textElement).margin};
                border: ${window.getComputedStyle(textElement).border};
            `;
            tempDiv.innerHTML = textElement.innerHTML;
            document.body.appendChild(tempDiv);
            
            const fullHeight = tempDiv.offsetHeight;
            const lineHeight = parseFloat(window.getComputedStyle(textElement).lineHeight) || 24;
            const maxHeight = lineHeight * 5; // 5 lines
            
            document.body.removeChild(tempDiv);
            
            // Show/hide button based on content height
            if (fullHeight > maxHeight + 10) { // Adding small buffer
                button.style.display = 'inline-block';
                textElement.classList.add('collapsed');
            } else {
                button.style.display = 'none';
                textElement.classList.remove('collapsed');
            }
        });
    }

    $(document).ready(function() {
        // Initialize Text Testimonials Carousel
        $('.text-testimonials-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                1024: { items: 2 }
            },
            onInitialized: function() {
                setTimeout(function() {
                    checkTextHeight();
                }, 300);
            },
            onResized: function() {
                setTimeout(function() {
                    checkTextHeight();
                }, 300);
            }
        });
    
    
        // Fade in animation on scroll
        function fadeInOnScroll() {
            $('.fade-in-up').each(function() {
                if ($(this).offset().top < $(window).scrollTop() + $(window).height() - 100) {
                    $(this).addClass('active');
                }
            });
        }
    
        fadeInOnScroll();
        $(window).scroll(fadeInOnScroll);
    
        // Tab switching animation
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            setTimeout(function() {
                $('.owl-carousel').trigger('refresh.owl.carousel');
                checkTextHeight();
            }, 200);
        });
    
        // Set equal height for testimonial cards
        function setEqualHeight() {
            var maxHeight = 0;
            var $cards = $('.text-testimonial-card');
            
            $cards.css('height', 'auto');
            
            $cards.each(function () {
                var cardHeight = $(this).outerHeight();
                if (cardHeight > maxHeight) {
                    maxHeight = cardHeight;
                }
            });
            
            $cards.css('height', maxHeight + 'px');
        }
    
        // When owl carousel is ready
        $('.text-testimonials-carousel').on('initialized.owl.carousel resized.owl.carousel refreshed.owl.carousel', function () {
            setTimeout(function() {
                setEqualHeight();
                checkTextHeight();
            }, 200);
        });
        
        // Check text height on window resize
        $(window).resize(function() {
            setTimeout(checkTextHeight, 100);
        });
        
        setTimeout(function() {
            setEqualHeight();
            checkTextHeight();
        }, 200);
    });

</script>
@endpush