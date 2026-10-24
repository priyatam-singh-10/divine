@php
    use App\Models\Course;
    $courses = Course::where('status', 'active')->get(); // get active courses
@endphp

@extends('layouts.admin')
@push('title', get_phrase('Batch Manager'))

@section('content')
  

<div class="container-fluid">
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Add New Batch') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-3">
        <div class="ol-card-body">

            <form action="{{ route('admin.batch.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 pb-2">
                        <div class="eForm-layouts">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="name">{{ get_phrase('Batch Name') }}<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter Course Batch Name') }}" required>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="start_date">{{ get_phrase('Start Date') }}</label>
                                <input type="date" name="start_date" class="form-control ol-form-control">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="max_students">{{ get_phrase('Max Students') }}</label>
                                <input type="number" name="max_students" class="form-control ol-form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="eForm-layouts">
                            <div class="fpb-7 mb-3">
                                <label for="course_id" class="form-label ol-form-label">{{ get_phrase('Select Course') }}<span class="text-danger ms-1">*</span></label>
                                <select class="ol-select2" name="course_id" required>
                                    <option value="">{{ get_phrase('Select a course') }}</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                                <input type="date" name="end_date" class="form-control ol-form-control">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label for="status" class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
                                <select class="ol-select2" name="status">
                                    <option value="1">{{ get_phrase('Active') }} </option>
                                    <option value="0">{{ get_phrase('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button class="btn ol-btn-primary float-end">{{ get_phrase('Save Batch') }}</button>
                        <a href="{{ route('admin.batch.index') }}" class="btn btn-secondary">
                            {{ get_phrase('Back') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
