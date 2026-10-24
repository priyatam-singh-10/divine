<style>
    .batch-tag {
    font-size: 13px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    min-width: 90px;
    text-align: center;
}

.batch-active {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.batch-none {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
}
</style>

<div class="w-100">
    <!-- Tab-2-Content -->
    <div class="mb-3 d-flex gap-2 align-items-center flex-wrap">
        <a href="#" onclick="ajaxModal('{{ route('modal', ['admin.course.create_section', 'id' => $course_details->id]) }}', '{{ get_phrase('Add new section') }}')" class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add section') }}
        </a>

        @if ($sections->count() > 0)
            <a href="#" onclick="ajaxModal('{{ route('modal', ['admin.course.lesson_type', 'id' => $course_details->id]) }}', '{{ get_phrase('Add new lesson') }}')" class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add lesson') }}</a>

            <!--<a href="#" onclick="ajaxModal('{{ route('modal', ['admin.quiz.create', 'id' => $course_details->id]) }}', '{{ get_phrase('Add new quiz') }}')" class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add quiz') }}</a>-->

            <a href="#" onclick="ajaxModal('{{ route('modal', ['admin.course.section_sort', 'id' => $course_details->id]) }}', '{{ get_phrase('Sort sections') }}')" class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Sort Section') }}</a>
        @endif
    </div>



    <ul class="ol-my-accordion">

        @forelse ($sections as $key => $section)
            @php
                /*$lessons = DB::table('lessons')
                    ->join('sections', 'lessons.section_id', 'sections.id')
                    ->select('lessons.*', 'sections.title as section_title')
                    ->where('lessons.section_id', $section->id)
                    ->orderBy('sort')*/
                $lessons = DB::table('lessons')
                    ->join('sections', 'lessons.section_id', 'sections.id')
                    ->leftJoin('batches', 'lessons.batch_id', '=', 'batches.id')
                    ->select(
                        'lessons.*',
                        'sections.title as section_title',
                        'batches.name as batch_name'
                    )
                    ->where('lessons.section_id', $section->id)
                    ->orderBy('lessons.sort')
                    ->get();
            @endphp
            <li class="single-accor-item">
                <div class="accordion-btn-wrap">
                    <div class="accordion-btn-title d-flex align-items-center">
                        <h4 class="title">{{ ++$key }}. {{ $section->title }}</h4>
                    </div>
                    <div class="accordion-button-buttons">

                        @if ($lessons->count() > 0)
                            <a href="#" onclick="ajaxModal('{{ route('modal', ['admin.course.lesson_sort', 'id' => $section->id]) }}', '{{ get_phrase('Sort lessons') }}'); event.stopPropagation();" class="btn btn-outline-gray-small">{{ get_phrase('Sort Lessons') }}
                            </a>
                        @endif

                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Edit section') }}" onclick="ajaxModal('{{ route('modal', ['admin.course.section_edit', 'id' => $section->id]) }}', '{{ get_phrase('Edit section') }}'); event.stopPropagation();" class="edit">
                            <span class="fi-rr-pencil"></span>
                        </a>

                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Delete section') }}" onclick="confirmModal('{{ route('admin.section.delete', $section->id) }}'); event.stopPropagation();" class="delete">
                            <span class="fi-rr-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="accoritem-body d-hidden">
                    <ul class="list-group-3">
                        @if ($lessons->count() > 0)
                            @foreach ($lessons as $key => $lesson)
                                <li>
                                   @php
                                        $hasBatch = !empty($lesson->batch_name);
                                    @endphp
                                    
                                    <h4 class="title d-flex align-items-center justify-content-between">
                                    
                                        <!-- LEFT: Lesson Name -->
                                        <span class="fw-semibold">
                                            {{ $lesson->title }}
                                        </span>
                                    
                                     <span class="batch-tag {{ $hasBatch ? 'batch-active' : 'batch-none' }}">
                                        {{ $hasBatch ? $lesson->batch_name : 'Unassigned' }}
                                    </span>
                                    
                                    </h4>

                                    <div class="buttons">
                                        @if ($lesson->lesson_type == 'quiz')
                                            <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Result') }}" onclick="ajaxModal('{{ route('modal', ['admin.quiz_result.index', 'id' => $lesson->id]) }}', '{{ get_phrase('Result') }}', 'modal-xl')" class="edit-delete">
                                                <span class="fi fi-rr-clipboard-list-check"></span>
                                            </a>

                                            <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Questions') }}" onclick="ajaxModal('{{ route('modal', ['admin.questions.index', 'id' => $lesson->id]) }}', '{{ get_phrase('Questions') }}', 'modal-lg')" class="edit-delete">
                                                <span class="fi fi-rr-poll-h"></span>
                                            </a>

                                            <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Edit quiz') }}" onclick="ajaxModal('{{ route('modal', ['admin.quiz.edit', 'id' => $lesson->id]) }}', '{{ get_phrase('Edit quiz') }}')" class="edit-delete">
                                                <span class="fi-rr-pencil"></span>
                                            </a>
                                        @endif

                                        @if ($lesson->lesson_type != 'quiz')
                                            <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Edit lesson') }}" onclick="ajaxModal('{{ route('modal', ['admin.course.lesson_edit', 'id' => $lesson->id]) }}', '{{ get_phrase('Edit lesson') }}')" class="edit-delete">
                                                <span class="fi-rr-pencil"></span>
                                            </a>
                                        @endif

                                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Delete lesson') }}" onclick="confirmModal('{{ route('admin.lesson.delete', $lesson->id) }}')" class="edit-delete">
                                            <span class="fi-rr-trash"></span>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <h4 class="title">{{ get_phrase('No lessons are available.') }}</h4>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @empty
            <li>
                <div class="row">
                    <div class="col-md-8">
                        <a onclick="ajaxModal('{{ route('modal', ['admin.course.create_section', 'id' => $course_details->id]) }}', '{{ get_phrase('Add new section') }}')" href="#" class="add-section-block text-center mt-4">
                            <p class="sub-title"><i class="fi-rr-add"></i></p>
                            <h3 class="title text-15px mt-2 fw-500">{{ get_phrase('Add a new Section') }}</h3>
                        </a>
                    </div>
                </div>
            </li>
        @endforelse
    </ul>
</div>
