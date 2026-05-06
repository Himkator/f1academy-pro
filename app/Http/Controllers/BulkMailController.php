<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Mail\BulkCourseMail;
use Illuminate\Support\Facades\Mail;

class BulkMailController extends Controller {

    public function sendToAll($courseId) {

        if (!in_array(session('user_role'), ['instructor', 'manager', 'admin'])) {
            return redirect('/')->with('error', 'Access denied.');
        }

        $course   = Course::with('students')->findOrFail($courseId);
        $students = $course->students()->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'No students enrolled in this course.');
        }

        foreach ($students as $student) {
            Mail::to($student->email)->send(
                new BulkCourseMail($student->login, $course->title)
            );
        }

        return back()->with('success', 'Email sent to all ' . $students->count() . ' students!');
    }
}