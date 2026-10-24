<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Forum;
use App\Models\Live_class;
use App\Models\Lesson;
use App\Models\Watch_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    // public function course_player(Request $request, $slug, $id = '')
    // {

        
    //     $course = Course::where('slug', $slug)->first();
       
    //     // check if course is paid
    //     if ($course->is_paid && auth()->user()->role != 'admin') {
    //         if (auth()->user()->role == 'student') { // for student check enrollment
    //             $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
    //             if (! $enrollment) {
    //                 Session::flash('error', get_phrase('Not registered for this course.'));
    //                 return redirect()->route('my.courses');
    //             }
    //         } elseif (auth()->user()->role == 'instructor') { // for instructor check who is course instructor
    //             if ($course->user_id != auth()->user()->id) {
    //                 Session::flash('error', get_phrase('Not valid instructor.'));
    //                 return redirect()->route('my.courses');
    //             }
    //         }
    //     }
             
    //     $check_lesson_history = Watch_history::where('course_id', $course->id)
    //         ->where('student_id', auth()->user()->id)->first();
              
    //     $first_lesson_of_course = Lesson::where('course_id', $course->id)->orderBy('sort', 'asc')->value('id');
      
    //     if ($id == '') {
    //         $id = $check_lesson_history->watching_lesson_id ?? $first_lesson_of_course;
    //     }
              
    //     // if user has any watched history or not
    //     if (! $check_lesson_history && $id > 0) {
    //         $data = [
    //             'course_id'          => $course->id,
    //             'student_id'         => auth()->user()->id,
    //             'watching_lesson_id' => $id,
    //             'completed_lesson'   => json_encode([])
    //         ];
    //        Watch_history::insert($data);
          
    //     }

    //     // when user plays a lesson, update that lesson id as watch history
    //     if ($id > 0) {
    //         Watch_history::where('course_id', $course->id)
    //             ->where('student_id', auth()->user()->id)
    //             ->update(['watching_lesson_id' => $id]);
    //     }
           
    //     $page_data['course_details'] = $course;
       
    //     $page_data['lesson_details'] = Lesson::where('id', $id)->first();
        
    //     $page_data['history']        = Watch_history::where('course_id', $course->id)->where('student_id', auth()->user()->id)->first();

    //     $forum_query = Forum::join('users', 'forums.user_id', 'users.id')
    //         ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
    //         ->latest('forums.id')
    //         ->where('forums.parent_id', 0)
    //         ->where('forums.course_id', $course->id);

    //     if (isset($_GET['search'])) {
    //         $forum_query->where(function ($query) use ($request) {
    //             $query->where('forums.title', 'like', '%' . $request->search . '%')->where('forums.description', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     $page_data['questions'] = $forum_query->get();
    //         dd($page_data);
    //     return view('course_player.index', $page_data);
    // }


// public function course_player(Request $request, $slug, $id = '')
// {
//     $course = Course::where('slug', $slug)->firstOrFail();

//     // Access Control
//     if ($course->is_paid && auth()->user()->role != 'admin') {
//         if (auth()->user()->role == 'student') {
//             $enrollment = Enrollment::where('course_id', $course->id)
//                 ->where('user_id', auth()->user()->id)
//                 ->first();

//             if (! $enrollment) {
//                 return redirect()->route('my.courses')->with('error', get_phrase('Not registered for this course.'));
//             }
//         } elseif (auth()->user()->role == 'instructor') {
//             if ($course->user_id != auth()->user()->id) {
//                 return redirect()->route('my.courses')->with('error', get_phrase('Not valid instructor.'));
//             }
//         }
//     }

//     // Get watch history
//     $check_lesson_history = Watch_history::where('course_id', $course->id)
//         ->where('student_id', auth()->user()->id)
//         ->first();

//     // Get first lesson
//     $first_lesson = Lesson::where('course_id', $course->id)
//         ->orderBy('sort', 'asc')
//         ->first();

//     $first_lesson_of_course = $first_lesson ? $first_lesson->id : null;

//     // Determine which lesson ID to use
//     if (empty($id)) {
//         $id = $check_lesson_history->watching_lesson_id ?? $first_lesson_of_course;
//     }

//     // Validate lesson existence and ownership
//     $lesson = Lesson::where('id', $id)
//         ->where('course_id', $course->id)
//         ->first();

//     // Handle if lesson is not found
//     if (! $lesson) {
//         return redirect()->route('my.courses')->with('error', get_phrase('The requested lesson was not found for this course.'));
//     }

//     // Watch history insert/update
//     if (! $check_lesson_history) {
//         Watch_history::insert([
//             'course_id' => $course->id,
//             'student_id' => auth()->user()->id,
//             'watching_lesson_id' => $lesson->id,
//             'completed_lesson' => json_encode([])
//         ]);
//     } else {
//         Watch_history::where('course_id', $course->id)
//             ->where('student_id', auth()->user()->id)
//             ->update(['watching_lesson_id' => $lesson->id]);
//     }

//     // Prepare view data
//     $page_data['course_details'] = $course;
//     $page_data['lesson_details'] = $lesson;
//     $page_data['history'] = Watch_history::where('course_id', $course->id)
//         ->where('student_id', auth()->user()->id)
//         ->first();

//     // Forum data
//     $forum_query = Forum::join('users', 'forums.user_id', '=', 'users.id')
//         ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
//         ->where('forums.parent_id', 0)
//         ->where('forums.course_id', $course->id)
//         ->latest('forums.id');

//     if ($request->has('search')) {
//         $searchTerm = $request->search;
//         $forum_query->where(function ($query) use ($searchTerm) {
//             $query->where('forums.title', 'like', "%{$searchTerm}%")
//                   ->orWhere('forums.description', 'like', "%{$searchTerm}%");
//         });
//     }

//     $page_data['questions'] = $forum_query->get();

//       // dd("hii",$page_data);
//     return view('course_player.index', $page_data);
// }

public function course_player(Request $request, $slug, $id = '')
    {

        $course = Course::where('slug', $slug)->firstOrNew();

        // check if course is paid
        if ($course->is_paid && auth()->user()->role != 'admin') {

            if (auth()->user()->role == 'student') {
                // get latest enrollment for this course and student
                $latest_enrollment = Enrollment::where('course_id', $course->id)
                    ->where('user_id', auth()->user()->id)
                    ->latest('created_at')
                    ->first();

                if (!$latest_enrollment) {
                    Session::flash('error', get_phrase('Not registered for this course.'));
                    return redirect()->route('course.details', ['slug' => $slug]);
                }

                // check if latest enrollment is expired (expiry_date is unix timestamp)
                if ($latest_enrollment->expiry_date && $latest_enrollment->expiry_date < time()) {
                    Session::flash('error', get_phrase('Your course accessibility has expired. You need to buy it again'));
                    return redirect()->route('course.details', ['slug' => $slug]);
                }
            }



            if (auth()->user()->role == 'instructor') { // for instructor check who is course instructor
                $instructor_ids = json_decode($course->instructor_ids ?? '[]', true);
                $enroll_status = enroll_status($course->id, auth()->user()->id);

                if (
                    $course->user_id != auth()->id() &&
                    !in_array(auth()->id(), $instructor_ids) &&
                    !$enroll_status
                ) {
                    Session::flash('error', get_phrase('Not valid instructor.'));
                    return redirect()->route('my.courses');
                }
            }
        }

        $check_lesson_history = Watch_history::where('course_id', $course->id)
            ->where('student_id', auth()->user()->id)->first();
        $first_lesson_of_course = Lesson::where('course_id', $course->id)->orderBy('sort', 'asc')->value('id');
        if ($id == '') {
            $id = $check_lesson_history->watching_lesson_id ?? $first_lesson_of_course;
        }

        // if user has any watched history or not
        if (! $check_lesson_history && $id > 0) {
            $data = [
                'course_id'          => $course->id,
                'student_id'         => auth()->user()->id,
                'watching_lesson_id' => $id,
                'completed_lesson'   => json_encode([])
            ];
            Watch_history::insert($data);
        }

        // when user plays a lesson, update that lesson id as watch history
        if ($id > 0) {
            Watch_history::where('course_id', $course->id)
                ->where('student_id', auth()->user()->id)
                ->update(['watching_lesson_id' => $id]);
        }

        $page_data['course_details'] = $course;
        $page_data['lesson_details'] = Lesson::where('id', $id)->firstOrNew();
        $page_data['history']        = Watch_history::where('course_id', $course->id)->where('student_id', auth()->user()->id)->first();
        // Get student enrollment for this course
        $student_enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->first();
        
        // Default empty collection
        $page_data['live_classes'] = collect();
        
        if ($student_enrollment) {
            $page_data['live_classes'] = Live_class::where('course_id', $course->id)
                ->where('batch_id', $student_enrollment->batch_id)
                ->orderBy('class_date_and_time', 'asc')
                ->get();
        }
        $forum_query = Forum::join('users', 'forums.user_id', 'users.id')
            ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
            ->latest('forums.id')
            ->where('forums.parent_id', 0)
            ->where('forums.course_id', $course->id);

        if (isset($_GET['search'])) {
            $forum_query->where(function ($query) use ($request) {
                $query->where('forums.title', 'like', '%' . $request->search . '%')->orWhere('forums.description', 'like', '%' . $request->search . '%');
            });
        }

        $page_data['questions'] = $forum_query->get();

        return view('course_player.index', $page_data);
    }



    public function set_watch_history(Request $request)
    {
        $course     = Course::where('id', $request->course_id)->first();
        $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
        if (! $enrollment && (auth()->user()->role != 'admin' || ! is_course_instructor($course->id))) {
            Session::flash('error', get_phrase('Not registered for this course.'));
            return redirect()->back();
        }

        $data['course_id']  = $request->course_id;
        $data['student_id'] = auth()->user()->id;

        $total_lesson = Lesson::where('course_id', $request->course_id)->pluck('id')->toArray();

        $watch_history = Watch_history::where('course_id', $request->course_id)
            ->where('student_id', auth()->user()->id)->first();

        if (isset($watch_history)) {
            $lessons = (array) json_decode($watch_history->completed_lesson);
            if (! in_array($request->lesson_id, $lessons)) {
                array_push($lessons, $request->lesson_id);
            } else {
                while (($key = array_search($request->lesson_id, $lessons)) !== false) {
                    unset($lessons[$key]);
                }
            }

            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::where('course_id', $request->course_id)->where('student_id', auth()->user()->id)->update($data);
        } else {
            $lessons                    = [$request->lesson_id];
            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::insert($data);
        }

        if (progress_bar($request->course_id) >= 100) {
            $certificate = Certificate::where('user_id', auth()->user()->id)->where('course_id', $request->course_id);

            if ($certificate->count() == 0) {
                $certificate_data['user_id']    = auth()->user()->id;
                $certificate_data['course_id']  = $request->course_id;
                $certificate_data['identifier'] = random(12);
                $certificate_data['created_at'] = date('Y-m-d H:i:s');
                Certificate::insert($certificate_data);
            }
        }

        return redirect()->back();
    }

    public function prepend_watermark()
    {
        return view('course_player.watermark');
    }
}
