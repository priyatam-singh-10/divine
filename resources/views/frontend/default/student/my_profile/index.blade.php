@extends('layouts.default')
@push('title', get_phrase('My profile'))
@push('meta')@endpush
@push('css')
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.min.css">

    <style>
        .iti {
            width: 100%;
        }
    </style>

@endpush
@section('content')
    <!------------ My profile area start  ------------>
    <section class="course-content pb-5">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Personal Information') }}</h4>
                    <div class="my-panel message-panel edit_profile">
                        <form action="{{ route('update.profile', $user_details->id) }}" method="POST">@csrf
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ get_phrase('Full Name') }}</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user_details->name }}" id="name" required maxlength="255">
                                    </div>
                                </div>
                                <div class="d-none col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ get_phrase('Email') }}</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user_details->email }}" id="email">
                                    </div>
                                </div>
                               <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">{{ get_phrase('Phone Number') }}<span
                                                class="text-danger">*</span></label>
                                        <!--<input type="tel" class="form-control" name="phone" value="{{ $user_details->phone }}" id="phone">-->
                                        <!-- Visible input -->
                                        <input type="tel" class="form-control" id="phone">

                                        <!-- Hidden input (actual DB value) -->
                                        <input type="hidden" name="phone" id="full_phone"
                                            value="{{ $user_details->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h5 class="mb-3">{{ get_phrase('Full Address') }}</h5>
                                </div>
                                <!-- Country -->
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="country" class="form-label">{{ get_phrase('Country') }}</label>
                                        <select class="form-control" name="country" id="country" required>
                                            <option value="">{{ get_phrase('Select Country') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ (isset($user_details->full_address['country']) && $user_details->full_address['country'] == $country->id) ? 'selected' : '' }}>
                                                    {{ ($country->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- State -->
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="state" class="form-label">{{ get_phrase('State') }}</label>
                                        <select class="form-control" name="state" id="state" required>
                                            <option value="">{{ get_phrase('Select State') }}</option>
                                            @if(isset($user_details->full_address['state']))
                                                @php
                                                    $states = DB::table('states')
                                                        ->where('country_id', $user_details->full_address['country'])
                                                        ->orderBy('name')
                                                        ->get();
                                                @endphp
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ $user_details->full_address['state'] == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!-- City -->
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="city" class="form-label">{{ get_phrase('City') }}</label>
                                        <select class="form-control" name="city" id="city" required>
                                            <option value="">{{ get_phrase('Select City') }}</option>
                                            @if(isset($user_details->full_address['city']))
                                                @php
                                                    $cities = DB::table('cities')
                                                        ->where('state_id', $user_details->full_address['state'])
                                                        ->orderBy('name')
                                                        ->get();
                                                @endphp
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $user_details->full_address['city'] == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!-- Address Line -->
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="address" class="form-label">{{ get_phrase('Address Line') }}</label>
                                        <input type="text" class="form-control" name="address" id="address"
                                               value="{{ $user_details->full_address['address'] ?? '' }}" maxlength="500" required>
                                    </div>
                                </div>
                                <!-- ZIP Code -->
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="zipcode" class="form-label">{{ get_phrase('ZIP Code') }}</label>
                                        <input type="text" class="form-control" name="zipcode" id="zipcode"
                                               value="{{ $user_details->full_address['zipcode'] ?? '' }}"  pattern="^[0-9]{6}$" maxlength="6" required
                           title="ZIP Code must be exactly 6 digits (no letters).">
                                    </div>
                                </div>
                            </div>
                            <button class="eBtn btn gradient mt-10">{{ get_phrase('Save Changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My profile area end  ------------>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let selectStateText = "{{ get_phrase('Select State') }}";
            let selectCityText = "{{ get_phrase('Select City') }}";

            $('#country').on('change', function() {
                let countryId = $(this).val();
                $('#state').html('<option value="">' + selectStateText + '</option>');
                $('#city').html('<option value="">' + selectCityText + '</option>');
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
                $('#city').html('<option value="">' + selectCityText + '</option>');
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
     <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>

    <script>
        "use strict";

        document.addEventListener("DOMContentLoaded", function() {

            const phoneInput = document.querySelector("#phone");
            const fullPhoneInput = document.getElementById("full_phone");
            const form = phoneInput.closest("form");

            const iti = window.intlTelInput(phoneInput, {
                preferredCountries: ["in", "us", "gb"],
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
            });

            // vERY IMPORTANT PART
            // Set number from DB (+919023432345)
            if (fullPhoneInput.value) {
                iti.setNumber(fullPhoneInput.value);
            }

            // On submit store full E.164 format again
            form.addEventListener("submit", function(e) {

                if (iti.isValidNumber()) {
                    fullPhoneInput.value = iti.getNumber();
                } else {
                    e.preventDefault();
                    alert("Please enter a valid phone number");
                    phoneInput.focus();
                }
            });

        });
    </script>
@endpush
