@extends('layouts.admin')
@push('title', get_phrase('Course enrollment'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $course = App\Models\Course::where('status', 'active')->orWhere('status', 'private')->orderBy('title', 'asc')->get();
        $students = App\Models\User::where('role', 'student')->orderBy('name', 'asc')->get();
    @endphp

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Enroll Students') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="ol-card p-4">
                <h3 class="title fs-14px mb-3">{{get_phrase('Enroll students')}}</h3>
                <div class="ol-card-body">
                    <form class="" action="{{ route('admin.student.post') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="multiple_user_id">{{ get_phrase('Users') }}<span class="required text-danger">*</span>
                            </label>
                            <select class="ol-select2 select2-hidden-accessible" name="user_id[]" multiple="multiple" required>
                                @foreach ($students as $student)
                                    <option value="{{$student->id}}">{{$student->name}} ({{$student->email}})</option>
                                @endforeach
                            </select>
                        </div>

                        <!--<div class="fpb-7 mb-3">-->
                        <!--    <label class="form-label ol-form-label" for="multiple_course_id">{{ get_phrase('Course to enrol') }}<span class="text-danger ms-1">*</span></label>-->

                        <!--    <select for='multiple_course_id' class="ol-select2 form-control ol-select2-multiple" data-toggle="select2" multiple="multiple" name="course_id[]"-->
                        <!--        id="multiple_course_id" data-placeholder="Choose ..." required>-->
                        <!--        <option value="">{{ get_phrase('Select a course') }}</option>-->
                        <!--        @foreach ($course as $row)-->
                        <!--            <option value="{{ $row->id }}">{{ $row->title }}</option>-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--</div>-->
                       {{-- Course --}}
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">
                                {{ get_phrase('Select Course') }}
                                <span class="text-danger">*</span>
                            </label>
                        
                            <select name="course_id[]" id="course_id" class="form-control ol-select2" required>
                                <option value="">{{ get_phrase('Select a course') }}</option>
                                @foreach ($course as $row)
                                    <option value="{{ $row->id }}">{{ $row->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Batch --}}
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">
                                {{ get_phrase('Select Batch (Optional)') }}
                            </label>
                        
                            <select name="batch_id" id="batch_id" class="form-control ol-select2">
                                <option value="">{{ get_phrase('Select course first') }}</option>
                            </select>
                        </div>



                        <button type="submit" class="btn ol-btn-primary mt-2">{{ get_phrase('Enroll student') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   @push('js')
<script>
$(document).ready(function () {

    $('#course_id').on('change', function () {
        var course_id = $(this).val();

        $('#batch_id').html('<option>Loading...</option>');

        if(course_id) {
            $.ajax({
                url: "{{ route('admin.get.batches') }}",
                type: "GET",
                data: { course_id: course_id },
                success: function (data) {
                    if(data.trim() == '') {
                        $('#batch_id').html('<option value="">No batch available (Enroll without batch)</option>');
                    } else {
                        $('#batch_id').html(data);
                    }
                },
                error: function () {
                    $('#batch_id').html('<option value="">No batch available</option>');
                }
            });
        } else {
            $('#batch_id').html('<option value="">Select course first</option>');
        }
    });

});
</script>
@endpush


@endsection
