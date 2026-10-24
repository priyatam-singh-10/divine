@extends('layouts.' . get_frontend_settings('theme'))
@push('title', get_phrase('Forgot Password'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
<!------------------- Login Area Start  ------>
 <section class="login-area d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="login-content-wrapper d-flex justify-content-center">
            <div class="row justify-content-center w-100">
                        
            <!--<div class="col-lg-7 col-md-6">-->
            <!--    <div class="login-img text-center">-->
            <!--        <img class="w-75 h-auto ms-auto me-auto" src="{{ asset('assets/frontend/default/image/login.gif') }}" alt="Forgot Password">-->
            <!--    </div>-->
            <!--</div>-->
                <div class="col-lg-5 col-md-6">
                    <form action="{{ route('password.email') }}" class="global-form login-form mt-25" method="POST">
                        @csrf
                        <h4 class="g-title">{{ get_phrase('Forgot Password') }}</h4>
                        <p class="description">{{ get_phrase('Submit your account email address.') }}</p>
    
                        <!-- Display Success Message -->
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        <!-- Display Validation Errors -->
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
    
                        <div class="form-group">
                            <label for="email" class="form-label">{{ get_phrase('Email') }}</label>
                            <input type="email" id="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="{{ get_phrase('Enter Your Email') }}" 
                                   value="{{ old('email') }}" required>
                        </div>
    
                        <button type="submit" class="eBtn gradient w-100 mt-5">{{ get_phrase('Send Request') }}</button>
                        <a href="{{ route('login') }}" class="eBtn gradient w-100 mt-3 text-center">{{ get_phrase('Back to login page') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!------------------- Login Area End  ------>
@endsection

@push('js')
@endpush
