@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Login'))

@section('content')

<style>

.login-area{
    background:#f7f7f7;
    min-height:80vh;
    display:flex;
    align-items:center;
}

.login-container{
    max-width:500px;
    margin:auto;
}

.login-card{
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.form-group label{
    font-weight:600;
}

.form-control{
    height:45px;
    border-radius:8px;
}

.btn-submit{
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:8px;
    font-weight:600;
}

.btn-submit:hover{
    background:#0b5ed7;
}

/* OTP BOXES */

.otp-container{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.otp-input{
    width:50px;
    height:50px;
    border:1px solid #ccc;
    text-align:center;
    font-size:20px;
    border-radius:8px;
}

</style>


<section class="login-area section-padding">

<div class="container">

<div class="login-container">

<div class="login-card">

<h4 class="mb-4 text-center">Student Login</h4>

<form method="POST" action="{{ route('student.login') }}">
@csrf


<!-- STEP 1 -->
<div id="phoneSection">

<div class="form-group">

<label>Phone Number</label>

<div class="d-flex gap-2 mt-2">

<select name="dial_code" id="dial_code" class="form-control" style="max-width:110px">

@foreach ($countries as $country)

<option value="{{ $country->dial_code }}"
{{ $country->dial_code == '+91' ? 'selected' : '' }}>

{{ $country->dial_code }}

</option>

@endforeach

</select>


<input type="tel"
name="phone"
id="phone"
class="form-control"
placeholder="Enter phone number"
maxlength="10"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'')">

</div>

</div>


<button type="button"
id="sendOtpBtn"
class="btn-submit w-100 mt-4"
onclick="sendOtp()">

Send OTP

</button>

</div>


<!-- STEP 2 -->
<div id="otpSection" style="display:none">

<div class="form-group mt-3">

<label>Enter OTP</label>

<div class="otp-container">

<input type="text" maxlength="1" class="otp-input">
<input type="text" maxlength="1" class="otp-input">
<input type="text" maxlength="1" class="otp-input">
<input type="text" maxlength="1" class="otp-input">

</div>

<input type="hidden" name="otp" id="otp">

</div>


<button type="submit" class="btn-submit w-100 mt-4">

Verify & Login

</button>

</div>

</form>
<div class="text-center mt-3">
    <p>
        Don't have an account?
        <a href="{{ route('student.register.form') }}">
            Create Account
        </a>
    </p>
</div>
</div>
</div>
</div>

</section>

@endsection
@push('js')
    <script>
        function sendOtp() {

            let btn = document.getElementById('sendOtpBtn');
            btn.disabled = true; // button disable
            btn.innerText = "Sending..."; // optional text change

            let phone = document.getElementById('phone').value;
            let dial_code = document.getElementById('dial_code').value;

            let full_phone = dial_code + phone;

            document.getElementById('phone').value = full_phone;

            fetch("{{ route('send.otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        phone: full_phone
                    })
                })
                .then(res => res.json())
                .then(data => {

                    // STEP 1 hide
                    document.getElementById("phoneSection").style.display = "none";

                    // STEP 2 show
                    document.getElementById("otpSection").style.display = "block";

                })
                .catch(err => {
                    btn.disabled = false; // agar error aaye to dubara enable
                    btn.innerText = "Send OTP";
                });
        }
        // function sendOtp() {

        //     let btn = document.getElementById('sendOtpBtn');
        //     btn.disabled = true;
        //     btn.innerText = "Sending...";

        //     let phone = document.getElementById('phone').value;
        //     let dial_code = document.getElementById('dial_code').value;

        //     if (phone.length !== 10) {
        //         alert("Please enter valid 10 digit mobile number");
        //         btn.disabled = false;
        //         btn.innerText = "Send OTP";
        //         return;
        //     }

        //     let full_phone = dial_code + phone;

        //     fetch("{{ route('send.otp') }}", {
        //             method: "POST",
        //             headers: {
        //                 "Content-Type": "application/json",
        //                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
        //             },
        //             body: JSON.stringify({
        //                 phone: full_phone
        //             })
        //         })
        //         .then(res => res.json())
        //         .then(data => {

        //             document.getElementById("phoneSection").style.display = "none";
        //             document.getElementById("otpSection").style.display = "block";

        //         })
        //         .catch(err => {
        //             btn.disabled = false;
        //             btn.innerText = "Send OTP";
        //         });
        // }

        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', function() {

                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateOtp();
            });

            input.addEventListener('keydown', function(e) {

                if (e.key === "Backspace" && this.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }

            });
        });

        function updateOtp() {
            let otp = "";
            document.querySelectorAll('.otp-input').forEach(input => {
                otp += input.value;
            });
            document.getElementById('otp').value = otp;
        }
    </script>
@endpush
