@extends('layouts.admin')

@push('title', get_phrase('Add Consultation Slot'))

@section('content')
<div class="ol-card">
    <div class="ol-card-body">
        <h4 class="mb-3">{{ get_phrase('Add New Slot') }}</h4>

        <form action="{{ route('admin.consultation-services-slots-store') }}" method="POST">
            @csrf

            <!-- Service -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Service') }}</label>
                <select name="service" class="form-select" required>
                    <option value="">-- Select Service --</option>
                    <option value="Hypnosis" {{ (isset($slot) && $slot->service == 'Hypnosis') ? 'selected' : '' }}>Hypnosis</option>
                    <option value="Reiki" {{ (isset($slot) && $slot->service == 'Reiki') ? 'selected' : '' }}>Reiki</option>
                    <option value="Yoga & Meditation" {{ (isset($slot) && $slot->service == 'Yoga & Meditation') ? 'selected' : '' }}>Yoga & Meditation</option>
                    <option value="Healing" {{ (isset($slot) && $slot->service == 'Healing') ? 'selected' : '' }}>Healing</option>
                    <option value="NLP" {{ (isset($slot) && $slot->service == 'NLP') ? 'selected' : '' }}>NLP</option>
                </select>
            </div>

            <!-- Date -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Slot Date') }}</label>
                <input type="date" 
                       name="slot_date" 
                       id="slot_date" 
                       class="form-control" 
                       required 
                       min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Start Time') }}</label>
                <input type="time" 
                       name="start_time" 
                       id="start_time" 
                       class="form-control" 
                       required>
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('End Time') }}</label>
                <input type="time" 
                       name="end_time" 
                       id="end_time" 
                       class="form-control" 
                       required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">{{ get_phrase('Status') }}</label>
                <select name="is_booked" class="form-select">
                    <option value="">Not Set</option>
                    <option value="0">Available</option>
                    <option value="1">Booked</option>
                </select>
            </div>

            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save Slot') }}</button>
        </form>
    </div>
</div>

{{-- Restrict time logic --}}
<script>
    const dateInput = document.getElementById('slot_date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    // When date changes
    dateInput.addEventListener('change', function() {
        const today = new Date();
        const selectedDate = new Date(this.value);

        if (selectedDate.toDateString() === today.toDateString()) {
            // If today, restrict start time to now
            let hours = today.getHours().toString().padStart(2, '0');
            let minutes = today.getMinutes().toString().padStart(2, '0');
            startTimeInput.min = `${hours}:${minutes}`;
        } else {
            // Future date -> reset restriction
            startTimeInput.removeAttribute('min');
        }
    });

    // When start time changes, set minimum for end time (+15 minutes)
    startTimeInput.addEventListener('change', function() {
        if (!this.value) return;
        let [hours, minutes] = this.value.split(':').map(Number);
        let date = new Date();
        date.setHours(hours);
        date.setMinutes(minutes + 15); // +15 minutes

        let endHours = date.getHours().toString().padStart(2, '0');
        let endMinutes = date.getMinutes().toString().padStart(2, '0');
        endTimeInput.min = `${endHours}:${endMinutes}`;
    });
</script>
@endsection
