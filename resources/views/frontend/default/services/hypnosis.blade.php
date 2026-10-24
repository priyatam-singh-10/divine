@extends('layouts.default')
@push('title', get_phrase('Hypnosis Services - Divine Touch'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <!------------ Breadcum Area Start  -------
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Services') }}</li>
                            </ol>
                        </nav>
                        <div class="row row-gap-3">
                            <div class="col-auto col-md-4 col-lg-3">
                                <h3 class="g-title mt-2">{{ get_phrase('Hypnosis') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ Breadcum Area End  ------->

    <div class="hypnosisSec">
        <!-- Hero Section -->
        <section class="hypnosis-hero-section section-padding">
            <div class="hypnosis-floating-elements"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="fw-bold mb-4">
                            Awaken the Power Within:
                            <span style="color: var(--gold);">Clinical & Spiritual Hypnosis</span>
                        </h1>
                        <p class="hypnosis-lead">
                            Transform your life through the ancient wisdom of hypnosis blended with modern science. Break free from limitations, heal emotional wounds, and unlock your true potential.
                        </p>
                         <div class="consultingEnq">
                            <button type="button" class="eBtn gradient builder-editable" data-bs-toggle="modal" data-bs-target="#consultingModal">
                                 <i class="fas fa-handshake me-2"></i>Book a Session
                            </button>
                         </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="https://divinetouch.info/public/assets/frontend/default/image/hypnosis-img.webp" alt="Hypnosis" class="img-fluid hypnosis-hero-img" style="max-width: 420px; margin:auto; width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </section>
<!-- Consulting Modal -->
<div class="modal fade consultModal" id="consultingModal" tabindex="-1" aria-labelledby="consultingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultingModalLabel">
                    <i class="fas fa-lightbulb me-2"></i>Book A Session
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="consultingForm" class="consulting-form">
                <div class="modal-body">
                    <!-- Hidden Service Field -->
                    <input type="hidden" name="page" id="servicePage" value="Hypnosis">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="fullName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="fullName" name="name" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" required>
                        </div>
                    </div>

                    <!-- Date and Time Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Select Date *</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Select Time *</label>
                            <select class="form-select time" id="time" name="time" required>
                                <option value="">-- Select Time --</option>
                                <!-- Available times will be populated via JS -->
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Additional Details</label>
                        <textarea class="form-control" id="message" rows="4" name="additional_details" placeholder="Please describe your specific needs and challenges..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-submit">
                        Submit Request
                    </button>
                </div>
            </form>

            <!-- Success Message (Initially Hidden) -->
            <div id="successMessage" class="modal-body" style="display: none;">
                <div class="success-message">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h4>Request Submitted Successfully!</h4>
                    <p>Thank you for your interest in our consulting services. We'll review your request and get back to you within 24 hours.</p>
                    <button type="button" class="btn btn-submit mt-3" data-bs-dismiss="modal">
                        <i class="fas fa-check me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Stats Section -->
        <section class="hypnosis-stats-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="hypnosis-stat-item">
                            <div class="hypnosis-stat-number">1135+</div>
                            <div>Lives Transformed</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="hypnosis-stat-item">
                            <div class="hypnosis-stat-number">15+</div>
                            <div>Years Experience</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="hypnosis-stat-item">
                            <div class="hypnosis-stat-number">8</div>
                            <div>Types of Hypnosis</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="hypnosis-stat-item">
                            <div class="hypnosis-stat-number">100%</div>
                            <div>Safe & Natural</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- What is Hypnosis Section -->
        <section class="section-padding bg-cream">
            <div class="container">
                <div class="row pb-5">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="title text-color mb-5">What is Hypnosis?</h2>
                        <p class="section-subtitle">
                            Hypnosis is a natural, trance-like state of deep focus and heightened suggestibility. You remain conscious and in control throughout the process, while your subconscious mind becomes more receptive to positive transformation.
                        </p>
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-4">
                            <div class="hypnosis-service-icon me-4">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-color mb-2">Ancient Wisdom</h3>
                                <p>Rooted in ancient Indian traditions like Tantra Shastra and refined through modern psychology.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-4">
                            <div class="hypnosis-service-icon me-4">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-color mb-2">Scientifically Validated</h3>
                                <p>Widely accepted by APA and British Medical Association for therapeutic purposes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Services Section -->
        <section class="section-padding bg-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="title text-color mb-5">Our Hypnosis Services</h2>
                    <p class="section-subtitle">Comprehensive healing solutions for mind, body, and spirit</p>
                </div>
    
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="hypnosis-service-card">
                            <div class="hypnosis-service-icon">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <h3 class="mb-4 text-color">Clinical Hypnosis</h3>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Anxiety Relief</li>
                                <li><i class="fas fa-check text-success me-2"></i>Depression Support</li>
                                <li><i class="fas fa-check text-success me-2"></i>Addiction Recovery</li>
                                <li><i class="fas fa-check text-success me-2"></i>Pain Management</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sleep Disorders</li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="col-lg-4 col-md-6">
                        <div class="hypnosis-service-card">
                            <div class="hypnosis-service-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h3 class="mb-4 text-color">Peak Performance</h3>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Motivation & Confidence</li>
                                <li><i class="fas fa-check text-success me-2"></i>Focus & Productivity</li>
                                <li><i class="fas fa-check text-success me-2"></i>Success Coaching</li>
                                <li><i class="fas fa-check text-success me-2"></i>Goal Achievement</li>
                                <li><i class="fas fa-check text-success me-2"></i>Performance Enhancement</li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="col-lg-4 col-md-6">
                        <div class="hypnosis-service-card">
                            <div class="hypnosis-service-icon">
                                <i class="fas fa-om"></i>
                            </div>
                            <h3 class="mb-4 text-color">Spiritual Hypnosis</h3>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Past Life Regression</li>
                                <li><i class="fas fa-check text-success me-2"></i>De-Hypnotization</li>
                                <li><i class="fas fa-check text-success me-2"></i>Inner Child Healing</li>
                                <li><i class="fas fa-check text-success me-2"></i>Karmic Healing</li>
                                <li><i class="fas fa-check text-success me-2"></i>Spiritual Awakening</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Process Section -->
        <section class="hypnosis-process-section section-padding">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="title text-color mb-4">How Hypnosis Works</h2>
                    <p class="section-subtitle">A gentle, safe, and effective 4-step process</p>
                </div>
    
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="hypnosis-process-step">
                            <div class="hypnosis-process-number">1</div>
                            <h2>Induction</h2>
                            <p>Guided relaxation and breathing to enter a peaceful trance state</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hypnosis-process-step">
                            <div class="hypnosis-process-number">2</div>
                            <h2>Deepening</h2>
                            <p>Enhancing the trance through focused techniques and visualization</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hypnosis-process-step">
                            <div class="hypnosis-process-number">3</div>
                            <h2>Suggestion</h2>
                            <p>Positive affirmations and healing suggestions tailored to your goals</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hypnosis-process-step">
                            <div class="hypnosis-process-number">4</div>
                            <h2>Emergence</h2>
                            <p>Gently bringing you back to waking awareness, feeling refreshed</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Myths Section -->
        <section class="section-padding bg-cream">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="text-center mb-5">
                            <h2 class="title text-color mb-4">Common Myths Debunked</h2>
                            <p class="section-subtitle">Let's clear up the misconceptions about hypnosis</p>
                        </div>
    
                        <div class="hypnosis-myth-card">
                            <h4 class="fw-bold text-default mb-2">Myth: You lose control under hypnosis</h4>
                            <p class="mb-0"><strong>Truth:</strong> You are always in control. Hypnosis works with your consent and cooperation.</p>
                        </div>
    
                        <div class="hypnosis-myth-card">
                            <h4 class="fw-bold text-default mb-2">Myth: Only weak minds can be hypnotized</h4>
                            <p class="mb-0"><strong>Truth:</strong> Hypnosis works best with focused, intelligent minds capable of concentration.</p>
                        </div>
    
                        <div class="hypnosis-myth-card">
                            <h4 class="fw-bold text-default mb-2">Myth: Hypnosis is supernatural or magical</h4>
                            <p class="mb-0"><strong>Truth:</strong> It's a scientifically studied psychological state with measurable brain activity.</p>
                        </div>
    
                        <div class="hypnosis-myth-card">
                            <h4 class="fw-bold text-default mb-2">Myth: Hypnosis is like sleep</h4>
                            <p class="mb-0"><strong>Truth:</strong> You remain conscious and aware throughout the entire process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Types of Hypnosis -->
        <section class="section-padding bg-white">
            <div class=" container ">
                <div class="text-center mb-5 ">
                    <h2 class="title text-color mb-4">Types of Hypnosis We Offer</h2>
                    <p class="section-subtitle ">Diverse approaches tailored to your unique needs</p>
                </div>
    
                <div class="row g-4 ">
                    <div class="col-lg-6 col-md-6 ">
                        <div class="d-flex align-items-start py-5 px-3 rounded-4 bg-white shadow">
                            <div class="hypnosis-service-icon me-3 mb-0" style="width: 50px; height: 50px; font-size: 1.2rem; ">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-color mb-2">Traditional Hypnosis</h3>
                                <p class="mb-0 ">Direct suggestions for habits, pain, or stress relief</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-6 col-md-6 ">
                        <div class="d-flex align-items-start py-5 px-3 rounded-4 bg-white shadow">
                            <div class="hypnosis-service-icon me-3 mb-0" style="width: 50px; height: 50px; font-size: 1.2rem; ">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-color mb-2">Ericksonian Hypnosis</h3>
                                <p class="mb-0">Indirect techniques using metaphors and storytelling</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex align-items-start py-5 px-3 rounded-4 bg-white shadow">
                            <div class="hypnosis-service-icon me-3 mb-0" style="width: 50px; height: 50px; font-size: 1.2rem; ">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Self-Hypnosis Training</h5>
                                <p class="mb-0 ">Learn techniques for confidence and personal change</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex align-items-start py-5 px-3 rounded-4 bg-white shadow">
                            <div class="hypnosis-service-icon me-3 mb-0" style="width: 50px; height: 50px; font-size: 1.2rem; ">
                                <i class="fas fa-users "></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-color mb-2">Group Hypnosis</h3>
                                <p class="mb-0 ">Ideal for motivation and success coaching sessions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- CTA Section -->
        <section class="hypnosis-cta-section">
            <div class="container ">
                <div class="row ">
                    <div class="col-lg-8 mx-auto ">
                        <h2 class="display-4 fw-bold mb-4 ">Ready to Transform Your Life?</h2>
                        <p class="fs-3 mb-5">
                            Take the first step towards healing, growth, and spiritual awakening. Your journey to a better you starts with a single decision.
                        </p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="tel:+91 797-681-9368" class="btn btn-outline-light btn-lg px-4 py-3 fs-3">
                                <i class="fas fa-phone me-2"></i>Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>  
    
<script>
    // Set minimum date to today (disable past dates)
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    });
    
    // Name validation - only allow letters and spaces
    document.getElementById('fullName').addEventListener('input', function(e) {
        // Remove any non-letter characters (keep spaces)
        let value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
        e.target.value = value;
    });
    
    // Mobile number validation
    document.getElementById('phone').addEventListener('input', function(e) {
        // Remove any non-digit characters
        let value = e.target.value.replace(/\D/g, '');
        
        // Limit to 10 digits
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        
        e.target.value = value;
    });
    
    // Add validation before form submission
    document.getElementById('consultingForm').addEventListener('submit', function(e) {
        const phone = document.getElementById('phone').value;
        
        // Name validation
        const nameField = document.getElementById('fullName');
        const name = nameField.value.trim();
        
        if (!name || !/^[a-zA-Z\s]+$/.test(name)) {
            toastr.error('Please enter a valid name (letters only).', 'Invalid Name');
            nameField.focus();
            return;
        }
        
        // Check if phone number is exactly 10 digits
        if (phone.length !== 10 || !/^\d{10}$/.test(phone)) {
            e.preventDefault();
            alert('Please enter a valid 10-digit mobile number.');
            document.getElementById('phone').focus();
            return false;
        }
        
        // Your existing form submission code continues here...
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        fetch('/api/consulting-services', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if(result.status){
                document.getElementById('consultingForm').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';
    
                   // Automatically close modal after 2.5 seconds
                setTimeout(() => {
                    const modalElement = document.getElementById('consultingModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
    
                    // Reset form for next time
                    document.getElementById('consultingForm').reset();
                    document.getElementById('consultingForm').style.display = 'block';
                    document.getElementById('successMessage').style.display = 'none';
                }, 2500);
            } else {
                alert('Failed to submit request.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const service = document.getElementById('servicePage').value;

   // Fetch available dates from backend
      fetch(`/available-dates?service=${encodeURIComponent(service)}`)
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const availableDates = data.dates; // ["2025-10-10","2025-10-11"]

            // Initialize flatpickr
            flatpickr(dateInput, {
                dateFormat: "Y-m-d",
                enable: availableDates, // Only enable available dates
                minDate: "today",       // Prevent past dates
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const dateStr = fp.formatDate(date, "Y-m-d");

                    // Highlight available dates
                    if (availableDates.includes(dateStr)) {
                        dayElem.classList.add("highlight-available");
                    }
                },
                onChange: function(selectedDates, dateStr) {
                    fetchSlots(dateStr);
                }
            });
        }
    });

 function fetchSlots(selectedDate) {
            const timeSelect = document.getElementById('time');
            const service = document.getElementById('servicePage').value;

            timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

            fetch(`/hardcoded-slots?service=${encodeURIComponent(service)}&date=${encodeURIComponent(selectedDate)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        data.slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.id;
                            option.text = slot.start_time + ' - ' + slot.end_time;
                            timeSelect.appendChild(option);
                        });
                    }
                });
        }


//     function fetchSlots(selectedDate) {
//     const timeSelect = document.getElementById('time');
//     const service = document.getElementById('servicePage').value;

//     if (!selectedDate) return;

//     timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

//     fetch(`/available-slots?service=${encodeURIComponent(service)}&date=${encodeURIComponent(selectedDate)}`)
//         .then(response => response.json())
//         .then(data => {
//             if (data.status === 'success') {
//                 data.slots.forEach(slot => {
//                     const option = document.createElement('option');
//                     option.value = slot.id;
//                     option.text = slot.start_time + ' - ' + slot.end_time;
//                     timeSelect.appendChild(option);
//                 });
//             } else {
//                 // Show the specific message from backend
//                 const option = document.createElement('option');
//                 option.value = '';
//                 option.text = data.message || 'No slots available';
//                 timeSelect.appendChild(option);

//                 // Optional: also show alert / toast
//                 alert(data.message);
//             }
//         })
//         .catch(err => {
//             console.error(err);
//             const option = document.createElement('option');
//             option.value = '';
//             option.text = 'Error fetching slots';
//             timeSelect.appendChild(option);
//         });
// }

});
</script>


@endsection
