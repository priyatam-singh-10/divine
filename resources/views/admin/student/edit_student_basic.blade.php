<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
<style>
.iti{
    width:100%;
}
</style>
<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control" id="user-name" @isset($student->name) value="{{ $student->name }}" @endisset required>
    </div>
</div>


<!--<div class="row mb-3">-->
<!--    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Biography') }}</label>-->
<!--    <div class="col-sm-8">-->
<!--        <textarea name="about" rows="3" class="form-control ol-form-control" id="short_description">@isset($student->about){{ $student->about }}@endisset</textarea>-->
<!--    </div>-->
<!--</div>-->


<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Phone') }}
    </label>
    <div class="col-sm-8">
        <input type="tel" id="user-phone" class="form-control ol-form-control" value="{{ $student->phone ?? '' }}">

        <!-- hidden field for final full number -->
        <input type="hidden" name="phone" id="full-phone">
    </div>
</div>


  <div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Address') }}
    </label>

    <div class="col-sm-8">
        <div class="row g-3">

            <!-- Country -->
            <div class="col-md-6">
                <label for="country" class="form-label">{{ get_phrase('Country') }}</label>
                <select class="form-control ol-form-control" name="country" id="country" required>
                    <option value="">{{ get_phrase('Select Country') }}</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ (isset($student->full_address['country']) && $student->full_address['country'] == $country->id) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- State -->
            <div class="col-md-6">
                <label for="state" class="form-label">{{ get_phrase('State') }}</label>
                <select class="form-control ol-form-control" name="state" id="state" required>
                    <option value="">{{ get_phrase('Select State') }}</option>

                    @if(isset($student->full_address['state']))
                        @php
                            $states = DB::table('states')
                                ->where('country_id', $student->full_address['country'])
                                ->orderBy('name')
                                ->get();
                        @endphp

                        @foreach($states as $state)
                            <option value="{{ $state->id }}"
                                {{ $student->full_address['state'] == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- City -->
            <div class="col-md-6">
                <label for="city" class="form-label">{{ get_phrase('City') }}</label>
                <select class="form-control ol-form-control" name="city" id="city" required>
                    <option value="">{{ get_phrase('Select City') }}</option>

                    @if(isset($student->full_address['city']))
                        @php
                            $cities = DB::table('cities')
                                ->where('state_id', $student->full_address['state'])
                                ->orderBy('name')
                                ->get();
                        @endphp

                        @foreach($cities as $city)
                            <option value="{{ $city->id }}"
                                {{ $student->full_address['city'] == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Address Line -->
            <div class="col-md-6">
                <label for="address" class="form-label">{{ get_phrase('Address Line') }}</label>
                <input type="text"
                       class="form-control ol-form-control"
                       name="address"
                       id="address"
                       value="{{ $student->full_address['address'] ?? '' }}"
                       maxlength="500"
                       required>
            </div>

            <!-- ZIP Code -->
            <div class="col-md-6">
                <label for="zipcode" class="form-label">{{ get_phrase('ZIP Code') }}</label>
                <input type="text"
                       class="form-control ol-form-control"
                       name="zipcode"
                       id="zipcode"
                       value="{{ $student->full_address['zipcode'] ?? '' }}"
                       pattern="^[0-9]{6}$"
                       maxlength="6"
                       required
                       title="ZIP Code must be exactly 6 digits">
            </div>

        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="photo" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('User image') }}</label>
    <div class="col-sm-8">
        <input type="file" name="photo" class="form-control ol-form-control" id="photo">
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const phoneInput = document.querySelector("#user-phone");
        const fullPhone = document.querySelector("#full-phone");

        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "in", // default India
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        // Save full international number before submit
        phoneInput.closest("form").addEventListener("submit", function() {
            if (iti.isValidNumber()) {
                fullPhone.value = iti.getNumber(); // +919876543210
            } else {
                alert("Please enter valid phone number");
                event.preventDefault();
            }
        });
    });
</script>
