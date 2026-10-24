@extends('layouts.instructor')
@push('title', get_phrase('Batch Manager'))
@section('content')

<div class="container-fluid">
    <h4 class="mb-4">Edit Batch</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('instructor.batch.update',$batch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Batch Name</label>
                    <input type="text" name="name" value="{{ $batch->name }}" class="form-control" required>
                </div>

                 {{-- Course Dropdown --}}
                <div class="mb-3">
                    <label>Select Course</label>
                    <select name="course_id" class="form-control" required>
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ $batch->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ $batch->start_date }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ $batch->end_date }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Max Students</label>
                    <input type="number" name="max_students" value="{{ $batch->max_students }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $batch->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $batch->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button class="btn btn-primary">Update Batch</button>
                <a href="{{ route('instructor.batch.index') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>
</div>

@endsection
