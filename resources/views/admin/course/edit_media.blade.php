<div class="row mb-3">
    <label for="thumbnail" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Thumbnail')}}</label>
    <div class="col-sm-10">
        <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
    </div>
</div>

<div class="row mb-3">
    <label for="banner" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Banner')}}</label>
    <div class="col-sm-10">
        <input type="file" name="banner" class="form-control ol-form-control" id="banner" accept="image/*" />
    </div>
</div>

<hr class="bg-secondary my-4">

<div class="row mb-3 d-none">
    <label for="preview_video_link" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Preview Video Link') }}
    </label>
    <div class="col-sm-10">

        <!-- Always Link (forced) -->
        <input type="radio"
            class="form-check-input d-none"
            value="link"
            name="preview_video_provider"
            id="preview_video_link"
            checked>
        <!--<label for="preview_video_link">-->
        <!--    {{ get_phrase('Video Link') }}-->
        <!--</label>-->

        <!-- Hidden File Option (kept for future) -->
        <input type="radio"
            class="form-check-input d-none"
            value="file"
            name="preview_video_provider"
            id="preview_video_file">
        <label class="d-none" for="preview_video_file">
            {{ get_phrase('Video File') }}
        </label>

    </div>
</div>

<!-- Always Show Link Input -->
<div class="row mb-3" id="preview_link_input">
    <label for="preview_link" class="form-label ol-form-label col-sm-2 col-form-label">
        {{ get_phrase('Preview Video link') }}
    </label>
    <div class="col-sm-10">
        <input type="text"
            name="preview_link"
            id="preview_link"
            class="form-control ol-form-control"
            value="{{ $course_details->preview }}">
        <small class="text-muted">
            {{get_phrase('Supported URL')}}:
            <b>{{get_phrase('Youtube')}}</b>
            {{get_phrase('or')}}
            <b>{{get_phrase('Vimeo')}}</b>
            <!--{{get_phrase('or')}}-->
            <!--<b>{{get_phrase('HTML5')}}</b>-->
        </small>
    </div>
</div>

<!-- Always Hidden File Upload -->
<div class="row mb-3 d-none" id="preview_file_input">
    <label for="preview" class="form-label ol-form-label col-sm-2 col-form-label">
        {{get_phrase('Preview Video File')}}
    </label>
    <div class="col-sm-10">
        <input type="file"
            name="preview"
            class="form-control ol-form-control"
            id="preview"
            accept="video/*" />
    </div>
</div>

<!-- Strong enforcement -->
<input type="hidden" name="preview_video_provider" value="link">
