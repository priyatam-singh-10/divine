@extends('layouts.' . get_frontend_settings('theme'))
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <section class="login-area d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="login-content-wrapper d-flex justify-content-center">
                <div class="row justify-content-center w-100">
            <!--<div class="col-lg-6 col-md-6">-->
            <!--    <div class="login-img">-->
            <!--        <img src="{{ asset('assets/frontend/' . get_frontend_settings('theme') . '/image/signup.gif') }}" alt="register-banner">-->
            <!--    </div>-->
            <!--</div>-->
                    <div class="col-lg-7 col-md-8">
                        <form action="{{ route('register') }}" class="global-form login-form mt-25" method="post">@csrf
                            <h4 class="g-title">{{ get_phrase('Sign Up') }}</h4>
                            <p class="description">{{ get_phrase('See your growth and get consulting support!') }}</p>
                        
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-5">
                                        <label class="form-label">{{ get_phrase('Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Your Name">
                                        <!--@error('name') <small class="text-danger">{{ $message }}</small> @enderror-->
                                    </div>
                                </div>
                            
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-5">
                                        <label class="form-label">{{ get_phrase('Phone') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Your Phone Number"  maxlength="10">
                                        <!--@error('phone') <small class="text-danger">{{ $message }}</small> @enderror-->
                                    </div>
                                </div>
                            
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-5">
                                        <label class="form-label">{{ get_phrase('Email') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                                        <!--@error('email') <small class="text-danger">{{ $message }}</small> @enderror-->
                                    </div>
                                </div>
                            
                                <div class="col-md-6 col-12">
                                   <div class="form-group mb-5 position-relative">
                                 <label for="password" class="form-label">{{ get_phrase('Password') }}</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="*********">
                                    <button type="button" class="btn btn-sm translate-middle-y eyeBtn" onclick="togglePassword()">
                                        <i class="fi-rr-eye" id="toggleIcon"></i>
                                    </button>
                                </div>

                                </div>
                            </div>
    
                        
                            <!--<div class="form-group mb-5">-->
                            <!--    <label class="form-label">{{ get_phrase('Address') }}</label>-->
                            <!--    <textarea name="address" class="form-control" rows="3" placeholder="Your Address">{{ old('address') }}</textarea>-->
                            <!--    @error('address') <small class="text-danger">{{ $message }}</small> @enderror-->
                            <!--</div>-->
                        
                            <button type="submit" class="eBtn gradient w-100">{{ get_phrase('Sign Up') }}</button>
                            <p class="mt-20">{{ get_phrase('Already have account.') }} <a href="{{ route('login') }}">{{ get_phrase('Sign in') }}</a></p>
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        "use strict";

        $(document).ready(function() {
            $('#showpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#password').attr('type');

                if (type == 'password') {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        });

        $(document).ready(function() {
            $('#showcpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#cpassword').attr('type');

                if (type == 'password') {
                    $('#cpassword').attr('type', 'text');
                } else {
                    $('#cpassword').attr('type', 'password');
                }
            });
        });
        
        // Name validation - only allow letters and spaces
        document.querySelector('input[name="name"]').addEventListener('input', function(e) {
            // Remove any non-letter characters (keep spaces)
            let value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
            e.target.value = value;
        });
        
        // Phone number validation - only allow digits
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Limit to 10 digits
            if (value.length > 10) {
                value = value.slice(0, 10);
            }
            
            e.target.value = value;
        });
        
        function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.replace('fi-rr-eye', 'fi-rr-eye-crossed');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.replace('fi-rr-eye-crossed', 'fi-rr-eye');
    }
}
    </script>
@endpush
