@extends('layouts.default')
@push('title', get_phrase('NLP Services - Divine Touch'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<div class="nlp-wrapper srvPage">
    <!-- Hero Section -->
    <section class="srvhero-section hypnosis-hero-section section-padding">
        <div class="hypnosis-floating-elements"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="fw-bold mb-4">
                        Neuro-Linguistic Programming  
                        <span class="text-accent">(NLP)</span>
                    </h1>
                    <p class="hypnosis-lead fw-semibold mb-4">Reprogram Your Mind, Recreate Your Life</p>
                    <p class="hypnosis-lead">
                        At Divine Touch, NLP sessions are designed to help you dissolve limiting beliefs, overcome fear and procrastination, and develop a powerful, success-oriented mindset.
                    </p>
                    <div class="consultingEnq">
                        <button type="button" class="eBtn gradient builder-editable" data-bs-toggle="modal" data-bs-target="#consultingModal">
                             <i class="fas fa-handshake me-2"></i>Book a Session
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="https://divinetouch.info/public/assets/frontend/default/image/nlp-srv.webp" alt="NLP" class="img-fluid hypnosis-hero-img" style="max-width: 420px; margin:auto; width: 100%; height: auto;">
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
                        <input type="hidden" name="page" id="servicePage" value="NLP">

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

    <!-- NLP Sessions Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="srvpageTitle display-4">What We Offer in NLP Sessions</h2>
                <p class="srv-subtitle">Transform your thoughts, transform your reality.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-anchor"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Anchoring</h4>
                        <p class="mb-3">Instill positive emotional states you can access anytime.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-retweet"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Reframing</h4>
                        <p class="mb-3">Shift perspective on past experiences to remove emotional charge.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-random"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Swish Technique</h4>
                        <p class="mb-3">Replace unwanted habits or thoughts with empowering ones.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Timeline Therapy</h4>
                        <p class="mb-3">Rewire emotional responses from past memories.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Rapport Building</h4>
                        <p class="mb-3">Improve personal and professional relationships.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="srvcard h-100">
                        <div class="srvicon mb-4">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Goal Alignment</h4>
                        <p class="mb-3">Set clear, compelling goals and align your subconscious for success.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p><strong>Best For:</strong> Confidence building, emotional control, clarity, productivity, and abundance mindset</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="reiki-cta-section">
        <div class="container ">
            <div class="row ">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h2 class="display-4 fw-bold mb-4">Ready to Reprogram Your Mind?</h2>
                    <p class="fs-3 mb-5">
                        Book your NLP session or connect with us to learn more about how NLP can transform your life. Your breakthrough starts here.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('contact.us') }}" class="btn btn-light btn-lg px-4 py-3 cta-btn-light fs-3">
                            <i class="fas fa-graduation-cap me-2"></i>Enroll in NLP Course
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