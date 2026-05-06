<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;

class ExportController extends Controller {

    public function exportProgress($courseId) {

        if (!in_array(session('user_role'), ['instructor', 'manager', 'admin'])) {
            return redirect('/')->with('error', 'Access denied.');
        }

        $course   = Course::with('students')->findOrFail($courseId);
        $students = $course->students()->get();

        // build CSV content
        $csv  = "Student Login,Full Name,Email,Enrolled At\n";

        foreach ($students as $student) {
            $enrolledAt = $student->pivot->created_at
                        ? $student->pivot->created_at->format('d M Y')
                        : 'N/A';

            $csv .= implode(',', [
                $student->login,
                '"' . $student->full_name . '"',
                $student->email,
                $enrolledAt,
            ]) . "\n";
        }

        $filename = 'progress_' . str_replace(' ', '_', $course->title) . '_' . date('Y-m-d') . '.csv';

        // return as downloadable CSV file
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}