@extends('layouts.' . get_frontend_settings('theme'))

@section('content')

<style>

.login-area{
    background:#f7f7f7;
    min-height:80vh;
    display:flex;
    align-items:center;
}

.login-container{
    max-width:520px;
    margin:auto;
}

.login-card{
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.form-group label{
    font-weight:600;
    margin-bottom:6px;
}

.form-control{
    height:46px;
    border-radius:8px;
}

.btn-submit{
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:8px;
    font-weight:600;
    transition:0.2s;
}

.btn-submit:hover{
    background:#0b5ed7;
}

/* OTP */

.otp-container{
    display:flex;
    justify-content:center;
    gap:12px;
    margin-top:15px;
}

.otp-input{
    width:55px;
    height:55px;
    border:1px solid #ccc;
    border-radius:10px;
    text-align:center;
    font-size:22px;
}

.signup-footer{
    text-align:center;
    margin-top:20px;
}

</style>

<section class="login-area">

<div class="container">

<div class="login-container">

<div class="login-card">

<h4 class="text-center mb-4">Student Signup</h4>

<form method="POST" action="{{ route('student.register.verifyOtp') }}">
@csrf


<!-- STEP 1 -->

<div id="signupSection">

<div class="form-group mb-3">
<label>Name</label>
<input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
</div>

{{--<div class="form-group mb-3">
<label>Email</label>
<input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
</div>--}}

{{-- PASSWORD REMOVED FOR OTP LOGIN --}}
{{--
<div class="form-group mb-3">
<label>Password</label>
<input type="password" name="password" id="password" class="form-control">
</div>
--}}

<div class="form-group mb-4">

<label>Phone Number</label>

<div class="d-flex gap-2">

<select id="dial_code" class="form-control" style="max-width:110px">

@foreach($countries as $country)

<option value="{{ $country->dial_code }}"
{{ $country->dial_code=='+91'?'selected':'' }}>

{{ $country->dial_code }}

</option>

@endforeach

</select>

<input type="text"
id="phone"
class="form-control"
placeholder="Enter mobile number"
maxlength="10"
oninput="this.value=this.value.replace(/[^0-9]/g,'')">

</div>

</div>

<button type="button"
class="btn-submit w-100"
onclick="sendOtp()">

Send OTP

</button>

</div>


<!-- STEP 2 OTP -->

<div id="otpSection" style="display:none">

<label class="text-center w-100">Enter OTP</label>

<div class="otp-container">

<input type="text" maxlength="1" class="otp-input" required>
<input type="text" maxlength="1" class="otp-input" required>
<input type="text" maxlength="1" class="otp-input" required>
<input type="text" maxlength="1" class="otp-input" required>

</div>

<input type="hidden" name="otp" id="otp">

<input type="hidden" name="phone" id="final_phone">

<button class="btn-submit w-100 mt-4">
Verify & Register
</button>

</div>

<div class="signup-footer">
Already have account?
<a href="{{ route('student.login.form') }}">Login</a>
</div>

</form>

</div>
</div>
</div>

</section>

@endsection
@push('js')
<script>
    document.querySelectorAll('.otp-input').forEach((input, index, arr) => {

    input.addEventListener('input', function(){

        if(this.value.length === 1 && index < arr.length - 1){
            arr[index + 1].focus();
        }

        let otp = '';
        arr.forEach(i => otp += i.value);

        document.getElementById('otp').value = otp;

    });

});
</script>

<script>
    function sendOtp(){

let phone = document.getElementById('phone').value;
let dial = document.getElementById('dial_code').value;

if(phone.length !== 10){
alert("Enter valid 10 digit mobile number");
return;
}

let full_phone = dial + phone;

document.getElementById('final_phone').value = full_phone;

fetch("{{ route('student.register.sendOtp') }}",{
method:"POST",
headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}"
},
body:JSON.stringify({
phone:full_phone,
name:document.getElementById('name').value,
// email:document.getElementById('email').value
})
})
.then(res=>res.json())
.then(data=>{
document.getElementById('signupSection').style.display="none";
document.getElementById('otpSection').style.display="block";
});

}
</script>
@endpush