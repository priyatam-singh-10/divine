<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Name') }}<span class="text-danger ms-1">*</span>
    </label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control @error('name') is-invalid @enderror" id="user-name"
               @isset($student->name) value="{{ $student->name }}" @endisset required>
        @error('name')
            <span class="text-danger mt-1 d-block">{{ $message }}</span>
        @enderror
    </div>
</div>
@php
$countries = DB::table('countries')->orderBy('name')->get();
@endphp

<div class="d-none row mb-3">
    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Biography') }}</label>
    <div class="col-sm-8">
        <textarea name="about" rows="3" class="form-control ol-form-control @error('about') is-invalid @enderror" id="short_description">@isset($student->about){{ $student->about }}@endisset</textarea>
        @error('about')
            <span class="text-danger mt-1 d-block">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
    <div class="col-sm-8">
        <input type="text" name="phone" class="form-control ol-form-control @error('phone') is-invalid @enderror"
            id="user-phone" @isset($student->phone) value="{{ old($student->phone) }}" @endisset>
        <input type="hidden" name="phone" id="full-phone">
    </div>
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!--<div class="row mb-3">-->
<!--    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Address') }}</label>-->
<!--    <div class="col-sm-8">-->
<!--        <input type="text" name="address" class="form-control ol-form-control @error('address') is-invalid @enderror" id="user-address"-->
<!--               @isset($student->address) value="{{ $student->address }}" @endisset>-->
<!--        @error('address')-->
<!--            <span class="text-danger mt-1 d-block">{{ $message }}</span>-->
<!--        @enderror-->
<!--    </div>-->
<!--</div>-->
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
                            {{ old('country') == $country->id ? 'selected' : '' }}>
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

                    @if(old('state'))
                        @php
                            $states = DB::table('states')
                                ->where('country_id', old('country'))
                                ->orderBy('name')
                                ->get();
                        @endphp

                        @foreach($states as $state)
                            <option value="{{ $state->id }}"
                                {{ old('state') == $state->id ? 'selected' : '' }}>
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

                    @if(old('city'))
                        @php
                            $cities = DB::table('cities')
                                ->where('state_id', old('state'))
                                ->orderBy('name')
                                ->get();
                        @endphp

                        @foreach($cities as $city)
                            <option value="{{ $city->id }}"
                                {{ old('city') == $city->id ? 'selected' : '' }}>
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
                       value="{{ old('address') }}"
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
                       value="{{ old('zipcode') }}"
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
        <input type="file" name="photo" class="form-control ol-form-control @error('photo') is-invalid @enderror" id="photo">
        @error('photo')
            <span class="text-danger mt-1 d-block">{{ $message }}</span>
        @enderror
    </div>
</div>
