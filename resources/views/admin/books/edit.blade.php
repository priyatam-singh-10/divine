@extends('layouts.admin')
@push('title', get_phrase('Edit Book'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<!-- Header -->
<div class="ol-card radius-8px print-d-none">
    <div class="ol-card-body my-3 py-4 px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-edit me-2"></i>
                <span>{{ get_phrase('Edit Book') }}</span>
            </h4>
        </div>
    </div>
</div>
<!-- Form -->
<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-4">
                <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-gap-3">
                        <!-- Left Column: Title, Author, Description -->
                        <div class="col-md-6">
                            <div class="row row-gap-3">
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Author') }}</label>
                                    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Author Description') }}</label>
                                    <input type="text" name="author_desc" class="form-control" value="{{ old('author_desc', $book->author_desc) }}" required>
                                </div>
                                <div class="col-md-12 fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="description" class="form-control ol-form-control text_editor" placeholder="{{ get_phrase('Enter Description') }}">{{ old('description', $book->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column: Status, Language, Pricing, Stock -->
                        <div class="col-md-6">
                            <div class="row row-gap-3">
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Status') }}</label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ $book->status == 'active' ? 'selected' : '' }}>{{ get_phrase('Active') }}</option>
                                        <option value="inactive" {{ $book->status == 'inactive' ? 'selected' : '' }}>{{ get_phrase('Inactive') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Made in') }}</label>
                                    <select class="ol-select2" name="language" required>
                                        <option value="">{{ get_phrase('Select your course language') }}</option>
                                        @foreach (App\Models\Language::get() as $language)
                                        <option value="{{ strtolower($language->name) }}" {{ strtolower($book->language) == strtolower($language->name) ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="eRadios">
                                    <div class="form-check">
                                        
                                     
                                        <input type="radio" name="pricing_type" value="1" class="form-check-input eRadioSuccess" id="paid" onchange="$('#paid-section').slideDown(200)" {{ $book->pricing_type == 'paid' ? 'checked' : '' }}>
                                        <label for="paid" class="form-check-label">{{ get_phrase('Paid') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="pricing_type" value="0" class="form-check-input eRadioSuccess" id="free" onchange="$('#paid-section').slideUp(200)" {{ $book->pricing_type == 'free' ? 'checked' : '' }}>
                                        <label for="free" class="form-check-label">{{ get_phrase('Free') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Price') }}</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $book->price) }}" required>
                                </div>
                                
                                 <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Discount Percentage') }} (%)</label>
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="100" 
                                        name="discount_percentage" 
                                        class="form-control" 
                                        value="{{ old('discount_percentage', $book->discount_percentage) }}"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ get_phrase('Stock') }}</label>
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}" required>
                                </div>
                            </div>
                        </div>
                        <!-- Dynamic Image Uploads -->
                        <!-- Dynamic Image Uploads -->
                        <div class="col-12 mt-3">
                            <label class="form-label">{{ get_phrase('Book Images') }}</label>
                            <div id="image-fields">
                                @php
                                $imageData = json_decode($book->image, true);
                                @endphp
                                @if (is_array($imageData))
                                @foreach ($imageData as $type => $images)
                                @foreach ($images as $imagePath)
                                <div class="d-flex gap-2 mb-2">
                                    <select name="image_type[]" class="form-select" required>
                                        <option value="cover" {{ $type == 'cover' ? 'selected' : '' }}>{{ get_phrase('Cover / Front') }}</option>
                                        <option value="back" {{ $type == 'back' ? 'selected' : '' }}>{{ get_phrase('Back') }}</option>
                                        <option value="extra_img" {{ $type == 'extra_img' ? 'selected' : '' }}>{{ get_phrase('Extra') }}</option>
                                    </select>
                                    <input type="file" name="images[]" class="form-control">
                                    <button type="button" class="btn btn-danger btn-sm remove-field">{{ get_phrase('Remove') }}</button>
                                    <img src="{{ asset($imagePath) }}" alt="Current Image" width="50" class="ms-2">
                                </div>
                                @endforeach
                                @endforeach
                                @else
                                <div class="d-flex gap-2 mb-2">
                                    <select name="image_type[]" class="form-select" required>
                                        <option value="cover">{{ get_phrase('Cover / Front') }}</option>
                                        <option value="back">{{ get_phrase('Back') }}</option>
                                        <option value="extra_img">{{ get_phrase('Extra') }}</option>
                                    </select>
                                    <input type="file" name="images[]" class="form-control" required>
                                    <button type="button" class="btn btn-danger btn-sm remove-field">{{ get_phrase('Remove') }}</button>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn ol-btn-primary mt-2" id="add-image-field">
                                <i class="fi-rr-plus me-1"></i> {{ get_phrase('Add More Images') }}
                            </button>
                        </div>

                        <!-- Video Upload or URL -->
                        <div class="col-12 mt-3">
                            <label class="form-label">{{ get_phrase('Book Video (Optional)') }}</label>
                            <div class="row row-gap-2">
                                <div class="col-md-6">
                                    <input type="file" name="video" class="form-control" accept="video/*">
                                    <small class="text-muted">Upload video file (mp4, mov, avi, wmv, max 20MB)</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="video_url" class="form-control" placeholder="Or paste YouTube/Vimeo link" value="{{ old('video_url', $book->video_url) }}">
                                    <small class="text-muted">Provide video URL (YouTube / Vimeo)</small>
                                </div>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn ol-btn-primary">
                                <i class="fi-rr-edit me-1"></i> {{ get_phrase('Update Book') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-image-field');
        const container = document.getElementById('image-fields');
        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.classList.add('d-flex', 'gap-2', 'mb-2');
            div.innerHTML = `
            <select name="image_type[]" class="form-select" required>
                <option value="cover">{{ get_phrase('Cover / Front') }}</option>
                <option value="back">{{ get_phrase('Back') }}</option>
                <option value="extra_img">{{ get_phrase('Extra') }}</option>
            </select>
            <input type="file" name="images[]" class="form-control" required>
            <button type="button" class="btn btn-danger btn-sm remove-field">{{ get_phrase('Remove') }}</button>
        `;
            container.appendChild(div);
        });
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-field')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>
@endpush