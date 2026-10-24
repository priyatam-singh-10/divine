<form action="{{ route('admin.webinar.live.class.store') }}" method="post">@csrf
    <!--<div class="fpb7 mb-3">-->
    <!--    <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>-->
    <!--    <input class="form-control ol-form-control" type="text" id="title" name="title" required>-->
    <!--</div>-->
       @php
            $module = \App\Models\BootcampModule::where('bootcamp_id', $id)
                        ->orderBy('sort','asc')
                        ->first();
        
            $bootcamp = \App\Models\Bootcamp::find($id);
        @endphp
        
        @if($module && $bootcamp)
        
            {{-- Hidden Title (same as bootcamp/webinar title) --}}
            <input type="hidden" name="title" value="{{ $bootcamp->title }}">
        
            {{-- Date Prefilled From Module Publish Date --}}
            <div class="col-sm-4 fpb7">
                <label class="form-label ol-form-label d-block">
                    {{ get_phrase('Date') }}
                </label>
        
                <input type="date"
                       class="form-control ol-form-control"
                       name="date"
                       min="{{ date('Y-m-d') }}"
                       value="{{ date('Y-m-d', $module->publish_date) }}"
                       required />
            </div>
        
        @endif


    <div class="row mb-3">
        <!--<div class="col-sm-4 fpb7">-->
        <!--    <label class="form-label ol-form-label d-block">{{ get_phrase('Date') }}</label>-->
        <!--    <input type="date" class="form-control ol-form-control" name="date" required />-->
        <!--</div>-->

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Start time') }}</label>
            <input type="time" class="form-control ol-form-control" name="start_time" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('End time') }}</label>
            <input type="time" class="form-control ol-form-control" name="end_time" required />
        </div>
    </div>
    @php
    $firstModule = \App\Models\BootcampModule::where('bootcamp_id', $id)
                    ->orderBy('sort', 'asc')
                        ->first();
    @endphp


    <div class="row mb-3">
        <div class="col-sm-6 fpb-7 d-none">
            <label class="form-label ol-form-label">{{ get_phrase('Module') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="module_id">
                <option value="">{{ get_phrase('Select an option') }}</option>
                @foreach (App\Models\BootcampModule::where('bootcamp_id', $id)->get() as $module)
                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                @endforeach
            </select>
        </div>
        
        @php
        $firstModule = \App\Models\BootcampModule::where('bootcamp_id', $id)->orderBy('sort', 'asc')->first();
        @endphp
        @if($firstModule)
            <input type="hidden" name="module_id" value="{{ $firstModule->id }}">
        @else
            <p class="text-danger">{{ get_phrase('No Details found for this webinar.') }}</p>
        @endif


        <div class="col-sm-6 fpb-7">
            <label class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status">
                <option value="">{{ get_phrase('Select an option') }}</option>
                <option value="upcoming">{{ get_phrase('Upcoming') }}</option>
                <option value="live">{{ get_phrase('live') }}</option>
                <option value="completed">{{ get_phrase('Completed') }}</option>
            </select>
        </div>
    </div>

    <div class="fpb-7 mb-3">
        <label for="description"
            class="form-label ol-form-label col-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor"></textarea>
    </div>

    <div class="fpb7">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add') }}</button>
    </div>
</form>

@include('admin.init')
