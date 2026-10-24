<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    // List batches
    public function index(Request $request)
{
    $query = Batch::with('course')
    ->withCount([
        'lessons as completed_lessons' => function ($q) {
            $q->whereNotNull('batch_id');
        }
    ]);

    // Search (batch name + course title)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%$search%")
              ->orWhereHas('course', function ($q) use ($search) {
                  $q->where('title', 'like', "%$search%");
              });
    }

    // Filter by batch name
    if ($request->filled('name')) {
        $query->where('name', 'like', "%{$request->name}%");
    }

    // Filter by course
    if ($request->filled('course_id')) {
        $query->where('course_id', $request->course_id);
    }

    $batches = $query->latest()->paginate(10)->withQueryString();

    $courses = \App\Models\Course::orderBy('title')->get();

    return view('admin.batches.index', compact('batches', 'courses'));
}


    // Create form
    public function create()
    {
         $courses = Course::where('status','active')->get();
        //  dd($courses);
        return view('admin.batches.create', compact('courses'));
    }

    // Store batch
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'name' => 'required',
        ]);

        Batch::create($request->all());

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch created successfully');
    }

    // Edit
    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        $courses = Course::where('status','active')->get();
        return view('admin.batches.edit', compact('batch', 'courses'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->update($request->all());

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch updated successfully');
    }

    // Delete
    public function destroy($id)
    {
        Batch::destroy($id);
        return back()->with('success', 'Batch deleted');
    }

    // Enroll student to batch
    public function enrollStudent(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
            'user_id'  => 'required'
        ]);

        $batch = Batch::findOrFail($request->batch_id);

        Enrollment::create([
            'user_id'    => $request->user_id,
            'course_id'  => $batch->course_id,
            'batch_id'   => $batch->id,
            'entry_date' => time(),
        ]);

        return back()->with('success', 'Student enrolled to batch');
    }
    public function getBatches(Request $request)
{
    $batches = \App\Models\Batch::where('course_id', $request->course_id)
                ->where('status', 1)
                ->get();

    if($batches->count() == 0){
        return '<option value="">batch available soon</option>';
    }

    $html = '<option value="">Select Batch (Optional)</option>';

    foreach($batches as $batch){
        $html .= '<option value="'.$batch->id.'">'.$batch->name.'</option>';
    }

    return $html;
}

}
