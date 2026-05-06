<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\MailController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\AdminController;
// use App\Models\User;    
// use App\Http\Controllers\LanguageController;

// Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Route::get('/', function () {return view('welcome');});

// //Auth routes
// Route::get('/register', [AuthController::class, 'showRegister']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::get('/login', [AuthController::class, 'showLogin']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/dashboard', function () {
//     if (!session('user_role')) {
//         return redirect('/login')->with('error', 'Please login first.');
//     }

//     $user = User::find(session('user_id'));

//     // courses this user created (instructor/admin)
//     $createdCourses = $user->courses()->get();

//     // courses this user enrolled in (student)
//     $enrolledCourses = $user->enrolledCourses()->get();

//     return view('dashboard', compact('createdCourses', 'enrolledCourses'));
// });
// //Course routes
// Route::get('/courses', [CourseController::class, 'showCourses']);
// Route::get('/courses/{id}', [CourseController::class, 'showCourseDetails']);
// Route::post('/manage-courses/store', [CourseController::class, 'createCourse']);
// Route::post('/manage-courses/delete', [CourseController::class, 'deleteCourse']);
// Route::get('/manage-courses', [CourseController::class, 'showManageCourses']);

// //Admin routes
// Route::get('/admin/manage-courses', [AdminController::class, 'showManageCourses']);
// Route::get('/admin', [AdminController::class, 'showManageUsers']);
// Route::post('/admin/change-role', [AdminController::class, 'changeUserRole']);

// Route::post('/courses/enroll', [MailController::class, 'enroll']);

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\BulkMailController;

// ── LANGUAGE ──
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// ── PUBLIC ──
Route::get('/', function () {
    $courses = Course::latest()->take(3)->get();
    return view('index', compact('courses'));
});

Route::get('/about', function () {
    return view('about');
});

// ── AUTH ──
Route::get('/register', function () { return view('register'); });

Route::post('/register', function () {
    $login    = request('login');
    $email    = request('email');
    $password = request('password');
    $role     = request('role', 'student');

    // only allow valid roles
    if (!in_array($role, ['student', 'manager', 'instructor'])) {
        $role = 'student';
    }

    $exists = User::where('login', $login)->orWhere('email', $email)->first();
    if ($exists) {
        return back()->with('error', 'Login or email already taken.')->withInput();
    }

    $user = User::create([
        'login'      => $login,
        'email'      => $email,
        'password'   => $password,
        'first_name' => request('firstName'),
        'last_name'  => request('lastName'),
        'dob'        => request('dob'),
    ]);

    $user->assignRole($role);

    return redirect('/login')->with('success', 'Account created! You can now log in.');
});

Route::get('/login', function () { return view('login'); });

Route::post('/login', function () {
    $user = User::where('login', request('login'))
                ->where('password', request('password'))
                ->first();

    if ($user) {
        $role = $user->getRoleNames()->first();
        session([
            'user_id'    => $user->id,
            'user_login' => $user->login,
            'user_role'  => $role,
        ]);

        if ($role === 'admin')      return redirect('/admin');
        if ($role === 'manager')    return redirect('/manager');
        if ($role === 'instructor') return redirect('/instructor');
        return redirect('/student');
    }

    return back()->with('error', 'Wrong login or password.')->withInput();
});

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

// ────────────────────────────────────────
// STUDENT ROUTES (4 pages)
// ────────────────────────────────────────
Route::get('/student', function () {
    if (session('user_role') !== 'student') return redirect('/');
    $courses = Course::latest()->take(3)->get();
    return view('student.main', compact('courses'));
});

Route::get('/student/courses', function () {
    if (session('user_role') !== 'student') return redirect('/');
    $courses = Course::all();
    return view('student.courses', compact('courses'));
});

Route::get('/student/about', function () {
    if (session('user_role') !== 'student') return redirect('/');
    return view('about');
});

Route::get('/student/profile', function () {
    if (session('user_role') !== 'student') return redirect('/');
    $user = User::with('enrolledCourses')->find(session('user_id'));
    return view('student.profile', compact('user'));
});

Route::post('/student/profile/update', function () {
    if (session('user_role') !== 'student') return redirect('/');
    User::find(session('user_id'))->update([
        'first_name' => request('first_name'),
        'last_name'  => request('last_name'),
        'phone'      => request('phone'),
        'bio'        => request('bio'),
    ]);
    return back()->with('success', 'Profile updated!');
});

Route::post('/student/enroll', [MailController::class, 'enroll']);

// ────────────────────────────────────────
// MANAGER ROUTES (4 pages)
// ────────────────────────────────────────
Route::get('/manager', function () {
    if (session('user_role') !== 'manager') return redirect('/');
    $courses     = Course::where('user_id', session('user_id'))
                         ->with('instructor')
                         ->withCount('enrollments')
                         ->get();
    $instructors = User::role('instructor')->get();
    return view('manager.main', compact('courses', 'instructors'));
});

Route::get('/manager/about', function () {
    if (session('user_role') !== 'manager') return redirect('/');
    return view('about');
});

Route::get('/manager/profile', function () {
    if (session('user_role') !== 'manager') return redirect('/');
    $user    = User::find(session('user_id'));
    $courses = Course::where('user_id', session('user_id'))->get();
    return view('manager.profile', compact('user', 'courses'));
});

Route::post('/manager/profile/update', function () {
    if (session('user_role') !== 'manager') return redirect('/');
    User::find(session('user_id'))->update([
        'first_name' => request('first_name'),
        'last_name'  => request('last_name'),
        'phone'      => request('phone'),
        'bio'        => request('bio'),
    ]);
    return back()->with('success', 'Profile updated!');
});

Route::get('/manager/courses/{id}', function ($id) {
    if (session('user_role') !== 'manager') return redirect('/');
    $course   = Course::with('enrollments.user')->findOrFail($id);
    $students = $course->students()->get();
    return view('manager.course_detail', compact('course', 'students'));
});

Route::post('/manager/courses/store', function () {
    if (session('user_role') !== 'manager') return redirect('/');

    $filePath = null;
    if (request()->hasFile('course_file')) {
        $filePath = request()->file('course_file')->store('courses', 'public');
    }

    Course::create([
        'title'         => request('title'),
        'level'         => request('level'),
        'description'   => request('description'),
        'price'         => request('price'),
        'file_path'     => $filePath,
        'user_id'       => session('user_id'),
        'instructor_id' => request('instructor_id'),
    ]);

    return back()->with('success', 'Course added!');
});

Route::post('/manager/courses/delete', function () {
    if (session('user_role') !== 'manager') return redirect('/');
    Course::where('id', request('course_id'))
          ->where('user_id', session('user_id'))
          ->firstOrFail()->delete();
    return back()->with('success', 'Course deleted.');
});

// ────────────────────────────────────────
// INSTRUCTOR ROUTES (4 pages)
// ────────────────────────────────────────
Route::get('/instructor', function () {
    if (session('user_role') !== 'instructor') return redirect('/');

    // only courses where this user is the instructor
    $courses = Course::where('instructor_id', session('user_id'))
                     ->withCount('enrollments')
                     ->get();

    return view('instructor.main', compact('courses'));
});

Route::get('/instructor/about', function () {
    if (session('user_role') !== 'instructor') return redirect('/');
    return view('about');
});

Route::get('/instructor/profile', function () {
    if (session('user_role') !== 'instructor') return redirect('/');
    $user    = User::find(session('user_id'));
    $courses = Course::where('instructor_id', session('user_id'))->get();
    return view('instructor.profile', compact('user', 'courses'));
});

Route::post('/instructor/profile/update', function () {
    if (session('user_role') !== 'instructor') return redirect('/');
    User::find(session('user_id'))->update([
        'first_name' => request('first_name'),
        'last_name'  => request('last_name'),
        'phone'      => request('phone'),
        'bio'        => request('bio'),
    ]);
    return back()->with('success', 'Profile updated!');
});

Route::get('/instructor/courses/{id}', function ($id) {
    if (session('user_role') !== 'instructor') return redirect('/');

    // make sure instructor can only see their own courses
    $course = Course::where('id', $id)
                    ->where('instructor_id', session('user_id'))
                    ->firstOrFail();

    $students = $course->students()->get();
    return view('instructor.course_detail', compact('course', 'students'));
});

Route::post('/instructor/courses/store', function () {
    if (session('user_role') !== 'instructor') return redirect('/');
    $filePath = null;
    if (request()->hasFile('course_file')) {
        $filePath = request()->file('course_file')->store('courses', 'public');
    }
    Course::create([
        'title'       => request('title'),
        'level'       => request('level'),
        'description' => request('description'),
        'price'       => request('price'),
        'file_path'   => $filePath,
        'user_id'     => session('user_id'),
    ]);
    return back()->with('success', 'Course added!');
});

Route::post('/instructor/courses/delete', function () {
    if (session('user_role') !== 'instructor') return redirect('/');
    Course::where('id', request('course_id'))
          ->where('user_id', session('user_id'))
          ->firstOrFail()->delete();
    return back()->with('success', 'Course deleted.');
});

// ────────────────────────────────────────
// ADMIN ROUTES (5 pages)
// ────────────────────────────────────────
Route::get('/admin', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    return view('admin.main', [
        'totalStudents'    => User::role('student')->count(),
        'totalManagers'    => User::role('manager')->count(),
        'totalInstructors' => User::role('instructor')->count(),
        'totalCourses'     => Course::count(),
        'totalEnrolled'    => Enrollment::count(),
    ]);
});

Route::get('/admin/students', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    $students = User::role('student')->with('enrolledCourses')->get();
    return view('admin.students', compact('students'));
});

Route::post('/admin/students/delete', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    User::find(request('user_id'))->delete();
    return back()->with('success', 'Student deleted.');
});

Route::get('/admin/courses', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    $courses  = Course::with('user')->withCount('enrollments')->get();
    $managers = User::role('manager')->get();
    $instructors = User::role('instructor')->get();
    return view('admin.courses', compact('courses', 'managers', 'instructors'));
});

Route::post('/admin/courses/store', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    $filePath = null;
    if (request()->hasFile('course_file')) {
        $filePath = request()->file('course_file')->store('courses', 'public');
    }
    Course::create([
        'title'       => request('title'),
        'level'       => request('level'),
        'description' => request('description'),
        'price'       => request('price'),
        'file_path'   => $filePath,
        'user_id'     => request('assigned_to'),
    ]);
    return back()->with('success', 'Course created!');
});

Route::post('/admin/courses/delete', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    Course::find(request('course_id'))->delete();
    return back()->with('success', 'Course deleted.');
});

Route::get('/admin/staff', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    $managers    = User::role('manager')->with('courses')->get();
    $instructors = User::role('instructor')->with('courses')->get();
    $courses     = Course::all();
    return view('admin.staff', compact('managers', 'instructors', 'courses'));
});

Route::post('/admin/staff/assign', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    Course::where('id', request('course_id'))
          ->update(['user_id' => request('user_id')]);
    return back()->with('success', 'Assigned successfully!');
});

Route::post('/admin/staff/delete', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    User::find(request('user_id'))->delete();
    return back()->with('success', 'User deleted.');
});

Route::get('/admin/profile', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    $user = User::find(session('user_id'));
    return view('admin.profile', compact('user'));
});

Route::post('/admin/profile/update', function () {
    if (session('user_role') !== 'admin') return redirect('/');
    User::find(session('user_id'))->update([
        'first_name' => request('first_name'),
        'last_name'  => request('last_name'),
        'phone'      => request('phone'),
        'bio'        => request('bio'),
    ]);
    return back()->with('success', 'Profile updated!');
});


// ── EXPORT PROGRESS (CSV download) ──
Route::get('/courses/{id}/export', [ExportController::class, 'exportProgress'])
     ->name('courses.export');

// ── EMAIL ALL STUDENTS ──
Route::post('/courses/{id}/email-students', [BulkMailController::class, 'sendToAll'])
     ->name('courses.email');