<div class="sidebar">
    <div class="row mb-4">
        <div class="col-6">
            <span class="d-inline-block py-1">{{ get_phrase('Filter') }}</span>
        </div>
        
         <div class="col-6 text-end">
            @if(request()->has('search') || request()->has('price') || request()->has('language'))
                <a href="{{ route('books') }}" class="btn btn-sm btn-outline-danger">
                    {{ get_phrase('Clear Filter') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Search Form -->
    <form class="mb-4" action="{{ route('books') }}" method="get">
        <div class="widget">
            <div class="search">
                <input type="text" class="form-control" name="search"
                       value="{{ request()->input('search') }}"
                       placeholder="{{ get_phrase('Search...') }}">
                <button type="submit" class="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Filters Form -->
    <form action="{{ route('books') }}" method="get" id="filter-courses">
        <!-- Keep search keyword if applied -->
        <input type="hidden" name="search" value="{{ request()->input('search') }}">

        <!------------------- Price Filter ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('Price') }}</h4>
            <ul class="entry-widget">
                <li class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input mt-0"
                               type="radio"
                               name="price"
                               value="paid"
                               id="price-paid"
                               @if(request()->input('price') === 'paid') checked @endif>
                        <label class="form-check-label" for="price-paid">Paid</label>
                    </div>
                </li>
                <li class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input mt-0"
                               type="radio"
                               name="price"
                               value="free"
                               id="price-free"
                               @if(request()->input('price') === 'free') checked @endif>
                        <label class="form-check-label" for="price-free">Free</label>
                    </div>
                </li>
            </ul>
        </div>

        <!------------------- Language Filter ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('Language') }}</h4>
            <ul class="entry-widget">
                @foreach (['english', 'hindi'] as $language)
                    <li class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input mt-0"
                                   type="radio"
                                   name="language"
                                   value="{{ $language }}"
                                   id="language-{{ $language }}"
                                   @if (request()->input('language') === $language) checked @endif>
                            <label class="form-check-label"
                                   for="language-{{ $language }}">
                                   {{ get_phrase(ucfirst($language)) }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </form>
</div>

@push('js')
<script>
"use strict";
$(document).ready(function() {
    // Auto-submit filter form when radio changes
    $('input[type="radio"]').change(function() {
        $('#filter-courses').trigger('submit');
    });
});
</script>
@endpush
