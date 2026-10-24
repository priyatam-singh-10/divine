@extends('layouts.admin')
@push('title', get_phrase('Batch Manager'))
@section('content')

<div class="container-fluid">
    <h4>Batch Details</h4>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $batch->name }}</p>
            <p><strong>Course ID:</strong> {{ $batch->course_id }}</p>
            <p><strong>Start Date:</strong> {{ $batch->start_date }}</p>
            <p><strong>End Date:</strong> {{ $batch->end_date }}</p>
            <p><strong>Max Students:</strong> {{ $batch->max_students }}</p>
            <p><strong>Status:</strong> {{ $batch->status == 1 ? 'Active' : 'Inactive' }}</p>

            <a href="{{ route('admin.batch.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

@endsection
