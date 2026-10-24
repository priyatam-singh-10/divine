@extends('layouts.default')
@push('title', get_phrase('Reiki Services - Divine Touch'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<div class="reiki-wrapper">
    <!-- Hero Section -->
    <section class="hypnosis-hero-section section-padding">
        <div class="hypnosis-floating-elements"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="fw-bold mb-4">
                        Reiki Healing at Divine Touch
                        <span class="text-accent">Balancing Body, Mind, and Spirit</span>
                    </h1>
                    <p class="hypnosis-lead">
                        Experience the transformative power of Reiki—channeling universal life energy for healing, balance, and spiritual growth. Our compassionate practitioners guide you on a journey to holistic well-being.
                    </p>
                    <div class="consultingEnq">
                        <button type="button" class="eBtn gradient builder-editable" data-bs-toggle="modal" data-bs-target="#consultingModal">
                             <i class="fas fa-handshake me-2"></i>Book a Session
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://divinetouch.info/public/assets/frontend/default/image/reiki-srv.webp" alt="Hypnosis" class="img-fluid hypnosis-hero-img" style="max-width: 420px; margin:auto; width: 100%; height: auto;">
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
                        <input type="hidden" name="page" id="servicePage" value="Reiki">

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

    <!-- What is Reiki Section -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="title display-5 mb-3">What is Reiki?</h2>
                    <p class="section-subtitle mb-5">
                        Reiki is a holistic energy healing technique from Japan, channeling universal life force energy (Rei = Universal, Ki = Energy) through the practitioner's hands to restore balance and promote natural healing on all levels—physical, emotional, mental, and spiritual.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-4">
                        <div class="reiki-service-card h-100">
                            <div class="reiki-service-icon mb-4">
                            <i class="fas fa-hands"></i>
                        </div>
                            <div>
                                <h4 class="fw-bold mb-4">Therapeutic & Spiritual</h4>
                                <p class="mb-0">Reiki at Divine Touch is both a therapeutic and spiritual tool for stress relief, emotional healing, and spiritual growth.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-4">
                        <div class="reiki-service-card h-100">
                            <div class="reiki-service-icon mb-4">
                            <i class="fas fa-leaf"></i>
                        </div>
                            <div>
                                <h4 class="fw-bold mb-4">Universal Life Energy</h4>
                                <p class="mb-0">Promotes natural healing by restoring energetic balance across all layers of being.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History of Reiki Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="title display-5 mb-3">History of Reiki</h2>
                <p class="section-subtitle">Honoring the lineage and evolution of Reiki healing</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-user-ninja"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Origins in Japan</h4>
                        <p class="mb-0">Founded by Dr. Mikao Usui in the early 20th century after a spiritual experience on Mount Kurama. Usui taught Reiki from 1922, passing it to Dr. Chujiro Hayashi, who systemized the practice.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Global Expansion</h4>
                        <p class="mb-0">Hawayo Takata introduced Reiki to the West in the 1930s. Today, Reiki is practiced worldwide in clinics, hospitals, and spiritual centers, blending Eastern wisdom with modern techniques.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Types of Reiki Section -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="title display-5 mb-3">Types of Reiki We Offer</h2>
                <p class="section-subtitle">Diverse approaches for holistic healing</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-sun"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Usui Reiki</h4>
                        <p class="mb-0">The original form focused on self-healing and universal energy.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Karuna Reiki</h4>
                        <p class="mb-0">Deep emotional and trauma healing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-mountain"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Tibetan Reiki</h4>
                        <p class="mb-0">Incorporates meditative chants and advanced symbols.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Shamballa Reiki</h4>
                        <p class="mb-0">Multidimensional healing and soul alignment.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-crosshairs"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Acu-Reiki & Reiki-Dowsing</h4>
                        <p class="mb-0">Fusion of Reiki with acupressure and dowsing, developed by Dr. Rekha Kale for precision energy healing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reiki Levels and Courses Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="title display-5 mb-3">Reiki Levels and Courses</h2>
                <p class="section-subtitle">Step-by-step training with certification and attunement</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Level 1 – Basic Healing</h4>
                        <ul class="list-unstyled">
                            <li>Duration: 1–2 days</li>
                            <li>Focus: Chakras, self-healing, energy sensing</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Level 2 – Advanced Healing</h4>
                        <ul class="list-unstyled">
                            <li>Three sacred symbols for emotional, mental, and distance healing</li>
                            <li>Enables professional practice</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-chess-king"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Master Level</h4>
                        <ul class="list-unstyled">
                            <li>Master symbol: Dai Ko Myo</li>
                            <li>Deepens healing, allows attuning others</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Grand Master Level</h4>
                        <ul class="list-unstyled">
                            <li>Advanced practitioners devoted to spiritual leadership and mentorship</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="mb-0 text-color">Training is available in-person and online, with ongoing support and practical sessions.</p>
            </div>
        </div>
    </section>

    <!-- Uses of Reiki Section -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="title display-5 mb-3">Uses of Reiki</h2>
                <p class="section-subtitle">Supporting healing across body, mind, and spirit</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Physical Health</h4>
                        <ul class="list-unstyled">
                            <li>Pain Management: Reduces chronic pain, arthritis, migraines</li>
                            <li>Better Sleep: Relieves insomnia and promotes calm</li>
                            <li>Immune Boost: Activates natural healing processes</li>
                            <li>Recovery Support: Aids post-surgery and injury healing</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Mental & Emotional Health</h4>
                        <ul class="list-unstyled">
                            <li>Stress Relief: Reduces anxiety and calms the mind</li>
                            <li>Emotional Healing: Clears fear, sadness, anger, trauma</li>
                            <li>Confidence & Clarity: Improves self-worth and focus</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-dove"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Spiritual Growth</h4>
                        <ul class="list-unstyled">
                            <li>Deepens meditation and connection to higher energy</li>
                            <li>Supports awakening and intuitive development</li>
                            <li>Used for past life regression (not clinically validated)</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Complementary Therapy</h4>
                        <ul class="list-unstyled">
                            <li>Used alongside medical treatments for comfort</li>
                            <li>Supports trauma, PTSD, and addiction recovery</li>
                            <li>Recognized in some hospitals and hospices</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Daily Life Applications</h4>
                        <ul class="list-unstyled">
                            <li>Self-Reiki for stress, energy clearing</li>
                            <li>Healing for pets, plants, and spaces</li>
                            <li>Enhancing creativity, intuition, and flow</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="mb-0 text-color">Note: Reiki is a complementary therapy and not a substitute for medical treatment.</p>
            </div>
        </div>
    </section>

    <!-- Benefits of Reiki Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="title display-5 mb-3">Benefits of Reiki</h2>
                <p class="section-subtitle">Holistic well-being for body, mind, and spirit</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Reduces Stress</h4>
                        <p class="mb-0">Lowers cortisol levels and promotes relaxation.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-hand-holding-medical"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Relieves Pain</h4>
                        <p class="mb-0">Helps with chronic pain, migraines, and injuries.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Emotional Balance</h4>
                        <p class="mb-0">Supports anxiety, depression, and grief healing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Improved Sleep</h4>
                        <p class="mb-0">Promotes restful sleep and overall relaxation.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Enhances Medical Treatments</h4>
                        <p class="mb-0">Reduces side effects and supports recovery.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="reiki-service-card h-100">
                        <div class="reiki-service-icon mb-4">
                            <i class="fas fa-magic"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Spiritual Connection</h4>
                        <p class="mb-0">Deepens intuition and spiritual growth.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="mb-0 text-color">While personal experiences are positive, scientific studies show mixed results. Some research indicates Reiki is more effective than placebo for stress and pain relief, while others recommend more rigorous trials.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="reiki-cta-section">
        <div class="container ">
            <div class="row ">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h2 class="display-4 fw-bold mb-4">Ready to Experience Reiki?</h2>
                    <p class="fs-3 mb-5">
                        Take the next step in your healing journey. Join our Reiki course for certification and mastery, or book a personalized appointment for a transformative session.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('contact.us') }}" class="btn btn-light btn-lg px-4 py-3 cta-btn-light fs-3">
                            <i class="fas fa-graduation-cap me-2"></i>Join Our Reiki Course
                        </a>
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

    // Initialize flatpickr to allow today and future dates
    flatpickr(dateInput, {
        dateFormat: "Y-m-d",
        minDate: "today",       // User can't select past dates
        defaultDate: null,      // Start blank
        onChange: function(selectedDates, dateStr) {
            if (dateStr) {
                fetchSlots(dateStr);
            }
        }
    });

    function fetchSlots(selectedDate) {
        const timeSelect = document.getElementById('time');
        const service = document.getElementById('servicePage').value;

        // Clear previous options
        timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

        // Fetch hardcoded slots for the selected date
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
});
</script>





@endsection