
@extends('layouts.instructor')
@push('title', get_phrase('Batch Manager'))

@section('content')
  

<div class="container-fluid">
    <h4 class="mb-4">Add New Batch</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('instructor.batch.store') }}" method="POST">
                @csrf

                {{-- Batch Name --}}
                <div class="mb-3">
                    <label>{{ get_phrase('Batch Name') }}</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            
           <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            
                {{-- Course Selection --}}
                <div class="mb-3">
                    <label>{{ get_phrase('Select Course') }}</label>
                    <select name="course_id" class="form-control" required>
                        <option value="">{{ get_phrase('Select a course') }}</option>
                     
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="mb-3">
                    <label>{{ get_phrase('Start Date') }}</label>
                    <input type="date" name="start_date" class="form-control">
                </div>

                {{-- End Date --}}
                <div class="mb-3">
                    <label>{{ get_phrase('End Date') }}</label>
                    <input type="date" name="end_date" class="form-control">
                </div>

                {{-- Max Students --}}
                <div class="mb-3">
                    <label>{{ get_phrase('Max Students') }}</label>
                    <input type="number" name="max_students" class="form-control">
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label>{{ get_phrase('Status') }}</label>
                    <select name="status" class="form-control">
                        <option value="1">{{ get_phrase('Active') }}</option>
                        <option value="0">{{ get_phrase('Inactive') }}</option>
                    </select>
                </div>

                <button class="btn btn-success">
                    {{ get_phrase('Save Batch') }}
                </button>

                <a href="{{ route('instructor.batch.index') }}" class="btn btn-secondary">
                    {{ get_phrase('Back') }}
                </a>

            </form>

        </div>
    </div>
</div>

@endsection
