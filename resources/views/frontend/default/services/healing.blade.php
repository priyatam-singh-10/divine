@extends('layouts.default')
@push('title', get_phrase('Healing Services - Divine Touch'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

<div class="reiki-wrapper srvPage">
    <!-- Hero Section -->
    <section class="srvhero-section hypnosis-hero-section section-padding">
        <div class="hypnosis-floating-elements"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="fw-bold mb-4">
                        Experience Transformative Healing for 
                        <span class="text-accent">Mind, Body & Spirit</span>
                    </h1>
                    <p class="hypnosis-lead fw-semibold">Release blocks, restore balance, and realign with your divine potential through transformative healing.</p>
                    <p class="hypnosis-lead">
                        At Divine Touch, we create a sacred space for deep healing and personal evolution. Led by Dr. Mahaveer Gautam—a globally respected hypnotherapist, NLP expert, and energy healer with 36+ years of experience—we blend ancient wisdom with modern science to guide you back to your true self. Each healing session is personalized to dissolve energetic blockages, emotional wounds, and subconscious limitations, empowering you to live with peace, abundance, and clarity.
                    </p>
                    
                    <div class="consultingEnq">
                        <button type="button" class="eBtn gradient builder-editable" data-bs-toggle="modal" data-bs-target="#consultingModal">
                             <i class="fas fa-handshake me-2"></i>Book a Session
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="https://divinetouch.info/public/assets/frontend/default/image/healing-srv.webp" alt="Hypnosis" class="img-fluid hypnosis-hero-img" style="max-width: 420px; margin:auto; width: 100%; height: auto;">
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
                    <input type="hidden" name="page" id="servicePage" value="Healing">

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
    
    <!-- Our Signature Healing Services Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="srvpageTitle display-4">Our Signature Healing Services</h2>
                <p class="srv-subtitle">Personalized sessions for mind, body, and spirit</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Reiki Healing</h4>
                        <p class="mb-3">Channel the universal life force energy to restore balance in body, mind, and spirit. Reiki clears energy blockages and promotes deep relaxation and healing.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Pain relief</li>
                            <li><i class="fas fa-check text-success me-2"></i> Chakra alignment</li>
                            <li><i class="fas fa-check text-success me-2"></i> Emotional harmony</li>
                            <li><i class="fas fa-check text-success me-2"></i> Heightened intuition</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Stress, chronic illness, trauma, manifesting abundance</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Theta Healing</h4>
                        <p class="mb-3">Access the theta brainwave state to reprogram your beliefs and attract what you truly desire. Theta Healing allows deep inner rewiring at the subconscious level.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Manifest wealth</li>
                            <li><i class="fas fa-check text-success me-2"></i> Improve health</li>
                            <li><i class="fas fa-check text-success me-2"></i> Heal relationships</li>
                            <li><i class="fas fa-check text-success me-2"></i> Release fear</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Limiting beliefs, recurring patterns, energetic stagnation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-infinity"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Past Life Regression (PLR)</h4>
                        <p class="mb-3">Explore previous incarnations to uncover the roots of present challenges. PLR heals karmic loops and releases stuck emotional energy.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Resolve phobias</li>
                            <li><i class="fas fa-check text-success me-2"></i> Release karmic debt</li>
                            <li><i class="fas fa-check text-success me-2"></i> Improve present relationships</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Relationship patterns, unexplainable fears, spiritual seekers</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Akashic Record Reading</h4>
                        <p class="mb-3">Tap into the divine library of your soul. The Akashic Records hold guidance on your life purpose, karmic lessons, and spiritual evolution.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Life clarity</li>
                            <li><i class="fas fa-check text-success me-2"></i> Decision-making</li>
                            <li><i class="fas fa-check text-success me-2"></i> Spiritual alignment</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Life path guidance, ancestral healing, business alignment</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-language"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Neuro-Linguistic Programming (NLP)</h4>
                        <p class="mb-3">Rewire your brain for success. NLP uses language and psychology to shift how you think, feel, and act—fast.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Boost confidence</li>
                            <li><i class="fas fa-check text-success me-2"></i> Overcome fears</li>
                            <li><i class="fas fa-check text-success me-2"></i> Achieve goals</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Career blocks, emotional patterns, self-esteem</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Hypnosis</h4>
                        <p class="mb-3">Harness the power of your subconscious to change habits, heal emotions, and attract your desired reality.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Deep relaxation</li>
                            <li><i class="fas fa-check text-success me-2"></i> Habit change</li>
                            <li><i class="fas fa-check text-success me-2"></i> Manifestation support</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Stress, addiction, anxiety, abundance blocks</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Inner Child Healing</h4>
                        <p class="mb-3">Reconnect with and heal your inner child to release deep-seated emotional wounds, restore innocence, and foster self-love and acceptance.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Emotional release</li>
                            <li><i class="fas fa-check text-success me-2"></i> Self-acceptance</li>
                            <li><i class="fas fa-check text-success me-2"></i> Healing childhood trauma</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Childhood trauma, low self-esteem, emotional blocks</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-female"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Womb Healing</h4>
                        <p class="mb-3">Restore feminine energy and clear generational trauma stored in the womb. Supports fertility, creativity, and emotional balance.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Feminine energy balance</li>
                            <li><i class="fas fa-check text-success me-2"></i> Release generational trauma</li>
                            <li><i class="fas fa-check text-success me-2"></i> Support fertility</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Fertility, creative blocks, ancestral healing</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-music"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Mantra Healing</h4>
                        <p class="mb-3">Harness the power of sacred sounds and mantras to clear negative energy, uplift the mind, and promote spiritual growth and protection.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Energy clearing</li>
                            <li><i class="fas fa-check text-success me-2"></i> Spiritual upliftment</li>
                            <li><i class="fas fa-check text-success me-2"></i> Protection from negativity</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Negative energy, spiritual seekers, mental clarity</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Holistic Healing</h4>
                        <p class="mb-3">Integrative healing that addresses mind, body, and spirit using a blend of energy work, counseling, and lifestyle guidance for total well-being.</p>
                        <ul class="list-unstyled mb-2">
                            <li><i class="fas fa-check text-success me-2"></i> Mind-body balance</li>
                            <li><i class="fas fa-check text-success me-2"></i> Personalized guidance</li>
                            <li><i class="fas fa-check text-success me-2"></i> Comprehensive wellness</li>
                        </ul>
                        <div class="mt-auto">
                            <span class="text-muted small">Best For: Overall wellness, stress, lifestyle change</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Healing Courses Section -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="srvpageTitle display-4">Healing Courses</h2>
                <p class="srv-subtitle">Learn and master the art of healing with our certified courses</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Reiki Healing Course</h4>
                        <p>Become a certified Reiki healer. Learn to channel universal energy for self and others, understand chakras, symbols, and receive attunements.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Theta Healing Course</h4>
                        <p>Master the theta brainwave state to reprogram beliefs and facilitate deep subconscious healing for yourself and clients.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-infinity"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Past Life Regression Course</h4>
                        <p>Learn the art of guiding clients into past lives for healing, clarity, and spiritual growth. Includes regression techniques and ethics.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Akashic Record Reading Course</h4>
                        <p>Access the soul's library. Learn to read Akashic Records for guidance, healing, and spiritual evolution for yourself and others.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-language"></i>
                        </div>
                        <h4 class="fw-bold mb-4">NLP Practitioner Course</h4>
                        <p>Become an NLP practitioner. Learn language and psychology tools to help clients shift patterns, boost confidence, and achieve goals.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Hypnosis Certification Course</h4>
                        <p>Learn clinical and spiritual hypnosis. Guide clients into trance for healing, habit change, and personal transformation.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Inner Child Healing Course</h4>
                        <p>Learn to guide clients in reconnecting with and healing their inner child, releasing emotional wounds and fostering self-love.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-female"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Womb Healing Course</h4>
                        <p>Master the art of womb healing to help others clear generational trauma, support fertility, and restore feminine energy.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-music"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Mantra Healing Course</h4>
                        <p>Learn the science and practice of mantra healing, using sacred sounds for energy clearing, protection, and spiritual growth.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Holistic Healing Course</h4>
                        <p>Become a holistic healer. Learn to integrate energy work, counseling, and lifestyle guidance for comprehensive client wellness.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="reiki-cta-section">
        <div class="container ">
            <div class="row ">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h2 class="display-4 fw-bold mb-4">Ready to Heal & Transform?</h2>
                    <p class="fs-3 mb-5">
                        Book your healing session or connect with us to learn more about our courses and services. Your journey to wholeness starts here.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('contact.us') }}" class="btn btn-light btn-lg px-4 py-3 cta-btn-light fs-3">
                            <i class="fas fa-graduation-cap me-2"></i>Join Our Course
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-4 py-3 fs-3">
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



//   function fetchSlots(selectedDate) {
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