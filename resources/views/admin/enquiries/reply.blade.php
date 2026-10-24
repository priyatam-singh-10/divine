
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.enquiries.reply', ['id' => $enquiry_id]) }}" method="post">
    @csrf
    <input type="hidden" name="send_to" value="{{ $enquiry_id }}">
    <input type="hidden" name="subject" value="{{ get_phrase('Thanks for getting in touch with Divine Touch – here is our reply') }}">
    <div class="fpb-7 mb-3">
        <textarea class="form-control ol-form-control" name="reply_message" rows="10"></textarea>
    </div>
    <div>
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Send reply') }}</button>
    </div>
</form>
