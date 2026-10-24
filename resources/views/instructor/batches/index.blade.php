@extends('layouts.instructor')
@push('title', get_phrase('Batch Manager'))
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Batches</h4>
        <a href="{{ route('instructor.batch.create') }}" class="btn btn-primary">
            + Add New Batch
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('instructor.batch.index') }}">
            <div class="row">

                <div class="col-md-3">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search batch or course"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <input type="text" name="name" class="form-control"
                           placeholder="Filter by batch name"
                           value="{{ request('name') }}">
                </div>

                <div class="col-md-3">
                    <select name="course_id" class="form-control">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('instructor.batch.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Students</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $key => $batch)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $batch->name }}</td>
                           <td>{{ $batch->course->title ?? '-' }}</td>
                            <td>{{ $batch->start_date }}</td>
                            <td>{{ $batch->end_date }}</td>
                            <td>{{ $batch->max_students }}</td>
                            <td>
                                @if($batch->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('instructor.batch.edit',$batch->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('instructor.batch.destroy',$batch->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this batch?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No batches found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
    {{ $batches->links() }}
</div>

        </div>
    </div>
</div>

@endsection