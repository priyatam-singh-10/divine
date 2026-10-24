@extends('layouts.default')
@push('title', get_phrase('About Us'))
@push('meta')@endpush
@push('css')@endpush

@section('content')

<div class="aboutUs">
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="http://www.divinetouch.info">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    About Us
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Dr. Gautam Section -->
    <section class="section-padding founder">
        <div class="container">
            <div class="row">
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="profileImg bg2 rounded-4 p-5 h-100">
                        <div class="profileImg">
                            <img src="https://divinetouch.info/public/assets/frontend/default/image/founder.webp" alt="Dr. Mahaveer Gautam" class="profile-image">
                            <div class="experience-badge">35+ Years Experience</div>
                            <h3 class="mt-4 text-center">Dr. Mahaveer Gautam</h3>
                            <p class="text-center mt-3 opacity-75">Holistic Healer &amp; Spiritual Guide</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" data-aos="fade-left">
                    <div class="profile-card">
                        <h2 class="section-title">Transforming Lives Through Ancient Wisdom</h2>
                        <p class="section-text text-justify">
                            With 35+ years of experience, I’ve dedicated my life to holistic healing and education. I specialize in Yoga, Naturopathy, Ayurveda, Clinical & Spiritual Hypnotherapy, and have been a Reiki Grand Master for over 30 years.
                        
                            I’ve also taught Mathematics, Physics, spiritual practices, and mantra healing for 35+ years. My Ayurveda work spans 30 years, offering natural, traditional healing. I’ve guided over 1,00,000 students, combining science and spiritual wisdom to heal and empower.
                        </p>
                        <ul class="highlight-list">
                            <li><i class="fas fa-users"></i>Trained 1 lakh+ students in Reiki, Hypnosis, and NLP</li>
                            <li><i class="fas fa-book"></i>Author of 5 books on spirituality and wealth manifestation</li>
                            <li><i class="fas fa-star"></i>Pioneer of "Manushya Ke Char Purusharth" for holistic living</li>
                            <li><i class="fas fa-globe"></i>Mission: "To make India a land of enlightened healers"</li>
                        </ul>
                        <div class="mt-4 d-flex">
                            <a href="mailto:info@divinetouch.info" class="btn eBtn btn-style1 me-4">Mail to Dr. Gautam</a>
                        
                            <!--<div class="consultingEnq">-->
                            <!--    <button type="button" class="eBtn gradient builder-editable" data-bs-toggle="modal" data-bs-target="#consultingModal">-->
                            <!--         <i class="fas fa-handshake me-2"></i>Book a Session-->
                            <!--    </button>-->
                            <!--</div>-->
                        </div>
                    </div>
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
                        <input type="hidden" name="page" value="About">
    
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
                        
                        <!-- Service Select Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="service" class="form-label">Select Service *</label>
                                <select class="form-control" id="service" name="service" required>
                                    <option value="">Select a service</option>
                                    <option value="Hypnosis">Hypnosis</option>
                                    <option value="Reiki">Reiki</option>
                                    <option value="Yoga">Yoga & Meditation</option>
                                    <option value="Healing">Healing</option>
                                    <option value="NLP">NLP</option>
                                </select>
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
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Details</label>
                            <textarea class="form-control" id="message" rows="4" name="address" placeholder="Please describe your specific needs and challenges..."></textarea>
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

    <!-- Vision Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="vision-mission-card">
                        <div class="card-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="section-title">Vision - India as a Golden Eagle</h3>
                        <h4 class="section-subtitle">Health • Wealth • Peace – A Trifecta for India's Rise</h4>
                        <p class="section-text">
                            We envision an India where every individual thrives in health, wealth, and inner peace, soaring like the majestic Golden Eagle through holistic healing and spiritual empowerment.
                        </p>
                        <ul class="highlight-list">
                            <li><i class="fas fa-heart"></i>Transform 10 crore families with holistic healing by 2030</li>
                            <li><i class="fas fa-infinity"></i>Create a ripple effect of abundance through healing arts</li>
                            <li><i class="fas fa-bullseye"></i> Our Mission Integrate ancient wisdom with modern healing sciences</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="vision-mission-card mt-4 mt-md-0">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="section-title">Mission - 10 Crore Health Revolution</h3>
                        <h4 class="text-olive">Healing Lives, Creating Opportunities</h4>
                        <div class="mission-stats">
                            <div class="row">
                                <div class="col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">10 Cr</span>
                                        <span class="stat-label">Health Transformations</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">10 Cr</span>
                                        <span class="stat-label">Employment Generation</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">1 Lakh</span>
                                        <span class="stat-label">Trees Yearly</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">100+</span>
                                        <span class="stat-label">Wellness Centers</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="highlight-list">
                            <li><i class="fas fa-hands-helping"></i>Reiki, Hypnosis, and Yoga for 10 crore families</li>
                            <li><i class="fas fa-graduation-cap"></i>Train certified healers and wellness entrepreneurs</li>
                            <li><i class="fas fa-tree"></i>Eco-Wellness initiatives across India</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="quote-text pulse">
                "A healthy, wealthy, and peaceful India is not a dream—it's our divine destiny waiting to unfold."
            </div>
            <div class="quote-author">– Dr. Mahaveer Gautam, Founder &amp; Spiritual Guide</div>
        </div>
    </section>

    <!-- Career Section -->
    <section class="section-padding career-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Become a Certified Healer & Wellness Entrepreneur</h2>
                    <h3 class="section-subtitle">Turn Your Passion into a Purposeful Career</h3>
                    <p class="section-text">
                        Join our mission to transform lives while building a meaningful career. With flexible learning options, global certification, and lifetime community support, you can earn while you heal.
                    </p>
                    
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-icon mx-auto">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h2 class="pb-3">Flexible Learning</h2>
                            <p>Online/Offline courses with global certification</p>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-icon mx-auto">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h2 class="pb-3">Earn Along with Us</h2>
                            <p>Monetize your skills through sessions and workshops</p>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card-icon mx-auto">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h2 class="pb-3">Growth Path</h2>
                            <p>From practitioner to master trainer with support</p>
                        </div>
                    </div>

                    <h4 class="section-subtitle mt-5">Open Roles:</h4>
                    <div class="career-roles">
                        <div class="role-badge">Reiki Masters</div>
                        <div class="role-badge">Hypnotherapists</div>
                        <div class="role-badge">NLP Coaches</div>
                        <div class="role-badge">Meditation Guides</div>
                        <div class="role-badge">Workshop Facilitators</div>
                    </div>

                    <!--<div class="mt-5">-->
                    <!--    <a href="mailto:careers@divinetouch.info" class="cta-btn">Apply Now</a>-->
                    <!--    <a href="#" class="cta-btn cta-btn-outline">Learn More</a>-->
                    <!--</div>-->
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


@endsection
@push('js')@endpush
