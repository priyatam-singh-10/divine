@extends('layouts.admin')

@push('title', get_phrase('Edit Consultation Slot'))

@section('content')
<div class="ol-card">
    <div class="ol-card-body">
        <h4 class="mb-3">{{ get_phrase('Edit Slot') }}</h4>

        <form action="{{ route('admin.consultation-services-slots-update', $slot->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Service -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Service') }}</label>
                <input type="text" name="service" class="form-control" value="{{ $slot->service }}" required>
            </div>

            <!-- Date -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Slot Date') }}</label>
                <input type="date" name="slot_date" class="form-control" value="{{ $slot->slot_date }}" required>
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Start Time') }}</label>
                <input type="time" name="start_time" class="form-control" value="{{ $slot->start_time }}" required>
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('End Time') }}</label>
                <input type="time" name="end_time" class="form-control" value="{{ $slot->end_time }}" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Status') }}</label>
                <select name="is_booked" class="form-select">
                    <option value="" {{ is_null($slot->is_booked) ? 'selected' : '' }}>Not Set</option>
                    <option value="0" {{ $slot->is_booked === 0 ? 'selected' : '' }}>Available</option>
                    <option value="1" {{ $slot->is_booked === 1 ? 'selected' : '' }}>Booked</option>
                </select>
            </div>

            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update Slot') }}</button>
        </form>
    </div>
</div>
@endsection
